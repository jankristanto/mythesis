<?php

// include the least recently used cache code
include_once 'lru.php';

/**
 * PHP SVM Solver based on Platt's SMO algorithm.
 * 
 * See the 'train' and 'test' functions for the entry points 
 * to this class. 
 * 
 * Usage:  
 * $svm = new PHPSVM();
 * $svm->train('data/train.dat', 'model.svm'); 
 *
 * Test/Classify:
 * $svm = new PHPSVM();
 * $svm->test('data/test.dat', 'model.svm', 'output.dat');
 * 
 * @author Ian Barber - http://phpir.com
 */
class PHPSVM {
		const UPPER_BOUND = 100;
		const TOLERANCE = 0.001;
		const EPSILON = 0.001;
		const GAMMA = 0.5;
		const NO_OUTPUT = true;
		const OUTPUT = false;
		const CACHE_INMEM = 0;
		const CACHE_LRU = 1;
		const CACHE_EXTERNAL = 2;
		
		protected $quiet; // suppress output if true
		protected $bias = 0; 
		protected $recordCount;
		protected $data = array();
		protected $targets = array();
		protected $lagrangeMults = array();
		protected $errorCache = array();
		protected $dotCache = array();
		protected $useExternal;
		protected $externalFh;
		protected $entryLength;
		protected $dotCachePath;
		
		/**
		 * Minimal constructor function
	 	 *
		 * dotCache can be:
		 * CACHE_INMEM for in memory caches
		 * CACHE_LRU for in memory least recently used access (better mem usage)
		 * CACHE_EXTERNAL for a file cache 
		 *
		 * @param quiet - set to PHPSVM::NO_OUTPUT to prevent echos
		 * @param dotCache - dot cache type
		 * @param dotCachePath - the string path the dotcache file will be written to if using EXTERNAL
		 */
		public function __construct($quiet = false, $dotCache = 0, $dotCachePath = '') {
			$this->quiet = $quiet;
			switch($dotCache) {
				case 1:
					// Use LRU Cache
					$this->dotCache = new LRUArray();
				break;
				case 2:
					// Use file based cache
					$this->useExternal = $dotCache;
					$this->dotCachePath = $dotCachePath;
					$this->entryLength = strlen(pack('f', 0.001)); // default pack size
				break;
			}
		}
		
		public function debug($data){
			echo "<pre>";
			print_r($data);
			echo "</pre>";
		}
		/** 
		 * Train on test data in the dataFile, then write
		 * the resulting SVM to a the modelFile. The model file is
		 * used in training. 
		 * 
		 * The format of the datafile should be the class (+1 or -1)
		 * followed by a series of space separated points in the format
		 * dimension:value, e.g. 23:0.02883
		 * 
		 * These should be in increasing order, but each entry does not 
		 * have to have every dimension specified. 
		 * 
		 * @param dataFile - path to the data file in svm light format
		 * @param modeFile - path where the model file should be written
		 * @param testDataFile - an optional file for test data 
		 */
		public function train($dataFile, $modelFile, $testDataFile = null) {
			$this->recordCount = $this->loadData($dataFile);
			// if we're using the external dotcache, precalc it
			if($this->useExternal) {
				$this->precalculateDots();
			}
			
			// Initialise lagrange multipliers - there will be one for each example
			for($i = 0; $i < $this->recordCount; $i++) {
				$this->lagrangeMults[$i] = 0;
			}
			
			// Loop over the records with examineExample, until we're 
			// not seeing changes any more. 
			$numChanged = 0; $examined = 0;
			while($numChanged > 0 || $examined == 0) {
				$numChanged = 0;
				if($examined == 0) {
					for($i = 0; $i < $this->recordCount; $i++) {
						$numChanged += $this->examineExample($i);
						
					}
				} else {
					foreach($this->lagrangeMults as $id => $val) {
						if($val != 0 && $val != self::UPPER_BOUND) {
							$numChanged += $this->examineExample($id);
						}
					}
				}
				
				if($examined == 0) {
					$examined = 1;
				} else if($numChanged == 0) {
					$examined = 0;
				}
			}
			
			
			if(isset($modelFile) && is_string($modelFile)) {
				$this->writeSVM($modelFile);
			}
			
			// close the file if we're precalcing
			if(isset($this->fh)) {
				fclose($this->fh);
				unset($this->fh);
			}
			
			if(isset($testDataFile) && is_string($testDataFile)) {
				$this->test($testDataFile, null, null);
			}
		}
		
		
		/**
		 * Load the $modelFile and use it to classify
		 * data in the $dataFile. The datafile should be in the
		 * same format as in the train function. Note that the first
		 * parameter of the data file can be 0 for unknown classes
		 * (for actual classification). If there is a +/-1 specified
		 *  then the function will calculate the accuracy by comparing
		 * the SVM decision to the target specified. 
		 * 
		 * The classification for each input will be written to the output
		 * file, so the classification for example 37 of the
		 * data file will be on line 37 of the output file. 
		 *
		 * This function has the second two parameters as optional, 
		 * particularly for use with the train function to allow testing
		 * the SVM that has just been built. 
		 * 
		 * @see train
		 * @param dataFile - path to the data file of test data
		 * @param modelFile - path to the model file
		 * @param output file - path where the output should be written
		 */ 
		public function test($dataFile, $modelFile = null, $outputFile = null) {
			$right = $wrong = 0;
			// If we're already in a valid SVM, we don't need the model
			if($modelFile) {
				$vectorCount = $this->readSVM($modelFile); 
			} else if(!count($this->lagrangeMults)) {
				if(!$this->quiet) { echo 'No model supplied'; }
				return false;
			} else {
				$vectorCount= $this->recordCount;
			}
			
			$this->recordCount = $this->loadData($dataFile, $vectorCount);
			
			if($outputFile) {
				$fh = fopen($outputFile, 'w'); 
			}
			
			if($this->useExternal) {
				$this->precalculateDots();
			}
			
			// classify the example
			$i=$vectorCount;
			$r = array();
			for($i; $i < $this->recordCount; $i++) {
				$classification = $this->classify($i);
				$r[] = $classification;
				if($outputFile) {
					fwrite($fh, $classification . "\n");
				}
				if(isset($this->targets[$i]) && $this->targets[$i] != 0) {
					if(($this->targets[$i] > 0) == ($classification > 0)) {
						$right++;
					} else {
						$wrong++;
					}
				}
			}
			/*
			for($i = $vectorCount; $i < $this->recordCount; $i++) {
				$classification = $this->classify($i);
				
				if($outputFile) {
					fwrite($fh, $classification . "\n");
				}
				if(isset($this->targets[$i]) && $this->targets[$i] != 0) {
					if(($this->targets[$i] > 0) == ($classification > 0)) {
						$right++;
					} else {
						$wrong++;
					}
				}
			}*/
			
			if($outputFile) {
				fclose($fh);				
			}
			
			// close the file if we're precalcing
			if(isset($this->fh)) {
				fclose($this->fh);
				unset($this->fh);
			}
			
			if(($right + $wrong) > 0 && !$this->quiet) {
				//echo "\nAccuracy: " . ($right/($right+$wrong)) . " over " . ($right+$wrong) . " examples.\n"; 
                $jan =  "\nAccuracy: " . ($right/($right+$wrong)) . " over " . ($right+$wrong) . " examples.\n"; 
			}
            
            return $r;
		}
		
		/**
		 * The SVM decision function. This is calculating which side 
		 * of the hyperplane the example in question falls on by 
		 * taking a weighted dot product (well, kernel) of all the support vectors
		 * and summing the score. 
		 * 
		 * The kernel function is used here, so in this case the dot product is 
		 * actually whatever is specified in there. 
		 * 
		 * This function is used both in the testing and as part of the classification
		 * process.
		 * 
		 * @see kernel
		 * @param $rowID the array index in $data of the example to be classified
		 * @return float the classification score - note the sign rather than the value
		 */
		protected function classify($rowID) {
			$score = 0;
			
			foreach($this->lagrangeMults as $key => $value) {
				
				if($value > 0) {  
					$score += $value * $this->targets[$key] * $this->kernel($rowID, $key);
				}
				
				
			}
			
			
			return $score - $this->bias;
		}
		
		/**
		 * This is the kernel function, the replacement for the dot product
		 * for non-linear classification. The current code is just a simple 
		 * gaussian RBF kernel, that generally takes the form 
		 * exp(||x - y||^2 / 2sigma^2). 
		 * 
		 * We make use of the GAMMA constant to handle the 2 sigma squared 
		 * part.
		 * 
		 * @see GAMMA
		 * @param indexA - the $data index for one example to be compared
		 * @param indexB - the $data index for the other example
		 * @return float - the comparison score
		 */
		protected function kernel($indexA, $indexB) {
			$score = 2 * $this->dot($indexA, $indexB);
			$xsquares = $this->dot($indexA, $indexA) +
						$this->dot($indexB, $indexB);
            $temp = exp(-self::GAMMA * ($xsquares - $score)); 
			return $temp;
		}
		
		/** 
		 * Take the dot product of the two vectors pointed at by
		 * the argument indices. Also cache dot products in 
		 * $dotCache, and use that where possible to speed things 
		 * up if useExternal is not true. If it is, then load the
		 * products from the precalculated cache. 
		 * 
		 * The dot product is simply the sum of each dimension in
		 * the first vector multiplied by the dimension in the second.
		 * 
		 * For example: {1, 2} dot {2, 2} = 1*2 + 2*2 = 6
		 * 
		 * The dot product of a vector and itself is it's length:
		 * {0.707, 0.707} dot {0.707, 0.707} ~ 1 
		 * 
		 * @param indexA - the $data index of the first example
		 * @param indexB - the $data index of the second example
		 * @return float - vector a dot vector b
		 */
		protected function dot($indexA, $indexB) {
			
			
			if($indexA > $indexB) {
				list($indexA, $indexB) = array($indexB, $indexA);
			}
									
			if($this->useExternal && isset($this->fh)) {	
				$recordPos = (((($this->recordCount * $indexA) - ((1 + $indexA) * ($indexA / 2))) 
								+ $indexA) * $this->entryLength) 
								+ (($indexB-$indexA) * $this->entryLength);
				fseek($this->fh, $recordPos, SEEK_SET);
				$var = fread($this->fh, $this->entryLength);
				$p = unpack('fscore', $var);
				return $p['score'];
			} else {
				$key = $indexA . '.' . $indexB;
				if(!isset($this->dotCache[$key])) {
						$this->dotCache[$key] = $this->calcDotProduct($indexA, $indexB);
				}
				
				return $this->dotCache[$key];
			}
			
		}
		
		/**
		 * Actually work out the dot product, without caching. 
		 * 
		 * @see dot
		 * @param indexA - the $data index of the first example
		 * @param indexB - the $data index of the second example
		 * @return float - vector a dot vector b
		 */
		protected function calcDotProduct($indexA, $indexB) {
			$score = 0;
			
			
			foreach($this->data[$indexA] as $id => $val) {
				if(isset($this->data[$indexB][$id])) {
					
					$score += $this->data[$indexB][$id] * $val;
				}
			}
			
			return $score;
		}
		
		
		/**
		 * Precalculate the dot products of all functions and store 
		 * in a file called dotcache.dot in the dotcachepath file. 
		 */
		protected function precalculateDots() {
			$this->fh = fopen($this->dotCachePath . 'dotcache.dot', 'wb');
			for($i = 0; $i < $this->recordCount; $i++) {
				for($j = $i; $j < $this->recordCount; $j++) {
					fwrite($this->fh, pack('f', $this->calcDotProduct($i, $j)));
				}
			}
			fclose($this->fh);
			$this->fh = fopen($this->dotCachePath . 'dotcache.dot', 'rb');
		}
		
		/**
		 * Output the SVM model in a retrievable way. 
		 * The format is only for use by this function,
		 * but is really just a straightforward output: 
		 * bias
		 * number of support vectors
		 * one line per lagrange multiplier
		 * one line per support vector
		 * 
		 * The last two correspond, so the 3rd lagrange 
		 * multiplier is for the third vector.
		 * 
		 * @param outputFile - the file path to write the model to
		 */
		protected function writeSVM($outputFile) {
			$fh = fopen($outputFile, 'w');
			fwrite($fh, $this->bias . "\n");
			$vectorCount = 0;
			foreach($this->lagrangeMults as $val) {
				if($val > 0) {
					$vectorCount++;
				}
			}
			fwrite($fh, $vectorCount . "\n");
			
			foreach($this->lagrangeMults as $key => $val) {
				if($val > 0) {
					fwrite($fh, $val . "\n");
				}
			}
			
			foreach($this->lagrangeMults as $key => $val) {
				if($val > 0) {
					$target = $this->targets[$key] > 0 ? '+': '';
					$target .= $this->targets[$key];
					fwrite($fh, $target);
					foreach($this->data[$key] as $id => $value) {
						fwrite($fh, " " . $id. ":" . $value);
					}
					fwrite($fh, "\n");
				}
			}
		}
		
		/** 
		 * Read in the SVM model file as written by writeSVM
		 * 
		 * @param modelFile - the path to the model 
		 * @return int - the count of vectors read in. 
		 */
		protected function readSVM($modelFile) {
			$fh = fopen($modelFile, 'r'); 
			$this->bias = (float)fgets($fh);
			$vectorCount = (int)fgets($fh);
			for($i = 0; $i < $vectorCount; $i++) {
				$this->lagrangeMults[$i] = (float)fgets($fh);
			}
			$this->readData($fh);
			
			return $vectorCount;
		}
		
 		/** 
 		 * Loads data from the file provided. The data should be in the 
 		 * SVM light format of target dim:val dim:val, e.g
		 * +1 3:0.66 40:0.001
		 * -1 3:0.11 34:0.20
		 * 
 		 * @param dataFile - the file to import data form 
		 * @param numLines - optional starting point for the count
		 * @return int - the number of vectors read in + numLines
		 */
		protected function loadData($dataFile, $numLines = 0) {
			$fh = fopen($dataFile, 'r');
			
			$numLines = $this->readData($fh, $numLines);
			fclose($fh);
			
			return $numLines;
		}
		
 		/**
		 * Function that actually does the parsing and loading of 
		 * data, expects a file handle pointing to a file as loaded
		 * by loadData
		 * 
		 * @see loadData
		 * @param resource - data file handle
		 * @param numLines - optional line count for internal use
		 * @return int - number of lines read in + numLines
  		 */
		protected function readData($dataHandle, $numLines = 0) {
			
			while($line = fgets($dataHandle)) {
				if(strlen($line) < 5) {
					continue;
				}
				$tokens = explode(" ", $line);
				
				if(count($tokens) < 2) {
					continue;
				}
				
				unset($line);
				$target = array_shift($tokens); 
				 
				// skip comments
				if($target == '#') {
					continue;
				}
				$vector = array(); 
				foreach($tokens as $token) {
					if(strlen($token) < 3) {
						continue;
					}
					list($key, $value) = explode(':', $token);
					$vector[$key] = (float)$value;
				}
				
				unset($tokens);
				$this->data[$numLines] = $vector;
				$this->targets[$numLines] = (int)$target;
				$numLines++;
				
			}
			
			return $numLines; 
		}
		
		/**
		 * Given an example, find another example we can optimise 
		 * against. This is one of the core steps of the algorithm, 
		 * finding the pairs of examples we can minimally optimise. 
		 * 
		 * @param rowID - the $data array index of the row to look at
		 * @return int - whether or not we changed anything
		 */
		protected function examineExample($rowID) {
			$target = $this->targets[$rowID]; // ambil label baris bersangkutan
			$alpha = $this->lagrangeMults[$rowID]; // nilai vector baris bersangkutan
			
			if($alpha > 0 && $alpha < self::UPPER_BOUND) {		
				$score = $this->errorCache[$rowID];
			} else {
				$score = $this->classify($rowID) - $target;
			}
			
			// result is < 0 if the point is in the margin
			$result = $target * $score;
			
			/* Now we actually try to find the partner point. 
			
			Step 1: Try to maximise $result - $result2, only considering support vectors
			(those with a lagrange mult > 0)
			
			Step 2: Choose any support vector (lag mult > 0) and try to optimise
			
			Step 3: Just loop through them till we find something that works!
			
			For 2 and 3 we choose a random start point in the array. 
			*/
			if( ($result < -self::TOLERANCE && $alpha < self::UPPER_BOUND) || 
				($result > self::TOLERANCE && $alpha > 0)) {
					
				// STEP 1
				$maxTemp = 0;
				$otherRowID = 0;
				foreach($this->lagrangeMults as $id => $value) {
					if($value > 0 && $value < self::UPPER_BOUND) {
						$result2 = $this->errorCache[$id];
						$temp = abs($result - $result2);
						if($temp > $maxTemp) {
							$maxTemp = $temp;
							$otherRowID = $id;
						}
					}
				}
				
				// If we found something, optimise against it
				if($otherRowID > 0) {
					if($this->takeStep($rowID, $otherRowID) == 1) {
						return 1;
					}
				}
				
				// STEP 2
				$endPoint = array_rand($this->lagrangeMults);
				for($k = $endPoint; $k < $this->recordCount + $endPoint; $k++) {
					$otherRowID = $k % $this->recordCount; 
					
					if($this->lagrangeMults[$otherRowID] > 0 && $this->lagrangeMults[$otherRowID] < self::UPPER_BOUND) {
						if($this->takeStep($rowID, $otherRowID) == 1) {
							return 1;
						}
					}
				}
				
				// STEP 3
				$endPoint = array_rand($this->lagrangeMults);
				for($k = $endPoint; $k < $this->recordCount + $endPoint; $k++) {
					$otherRowID = $k % $this->recordCount; 
					
					if($this->takeStep($rowID, $otherRowID) == 1) {
						return 1;
					}
				}
				
			}
			
			// Couldn't find anything to optimise with
			return 0;
		}
		
		/** 
		 * This is the optimisation step, where we take 
		 * two points and perform the join optimisation on them.
		 * 
		 * @param $rowID - first example
		 * @param $otherRowId - second example
		 * @return bool success in optimising
		 */
		protected function takeStep($rowID, $otherRowID) {
			if($rowID == $otherRowID) {
				return 0;
			}
			
			$alpha1 = $this->lagrangeMults[$rowID];
			$target1 = $this->targets[$rowID];
			if($alpha1 > 0 && $alpha1 < self::UPPER_BOUND) {
				$result1 = $this->errorCache[$rowID];
			} else {
				$result1 = $this->classify($rowID) - $target1;
			}
			
			$alpha2 = $this->lagrangeMults[$otherRowID];
			$target2 = $this->targets[$otherRowID];
			if($alpha2 > 0 && $alpha2 < self::UPPER_BOUND) {
				$result2 = $this->errorCache[$otherRowID];
			} else {
				$result2 = $this->classify($otherRowID) - $target2;
			}
			
			$score = $target1 * $target2;
			
			// calc low and high constraints on the multiplier
			$low = $high = 0;
			if($target1 == $target2) {
				$gamma = $alpha1 + $alpha2;
				if($gamma > self::UPPER_BOUND) {
					$low = $gamma - self::UPPER_BOUND;
					$high = self::UPPER_BOUND;
				} else { 
					$low = 0;
					$high = $gamma;
				}
			} else {
				$gamma = $alpha1 - $alpha2; 
				if($gamma > 0) {
					$low = 0;
					$high = self::UPPER_BOUND - $gamma;
				} else {
					$low = -$gamma;
					$high = self::UPPER_BOUND;
				}
			}
			
			if($low == $high) {
				return 0;
			}
			
			$k11 = $this->kernel($rowID, $rowID); 
			$k12 = $this->kernel($rowID, $otherRowID);
			$k22 = $this->kernel($otherRowID, $otherRowID);
			$eta = 2 * $k12 - $k11 - $k22;
			
			// Recalc lagrange mult
			if($eta < 0) {
				// unconstrained maximum
				$a2 = $alpha2 + $target2 * ($result2 - $result1) / $eta;
				if($a2 < $low) {
					$a2 = $low;
				} else if($a2 > $high) {
					$a2 = $high;
				}
			} else {
				// constrained maximum
				$x1 = $eta/2.0;
				$x2 = $target2 * ($result1 - $result2) - $eta * $alpha2;
				$lowObj = $x1 * $low * $low + $x2 * $low;
				$highObj = $x1 * $high * $high + $x2 * $high;
				
				if($lowObj > ($highObj + self::EPSILON)) {
					$a2 = $low;
				} else if($lowObj < ($highObj - self::EPSILON)) {
					$a2 = $high;
				} else {
					$a2 = $alpha2;
				}
			}
			
			if(abs($a2 - $alpha2) < self::EPSILON *($a2 + $alpha2 + self::EPSILON)){ 
				return 0;
			}
			
			// finally determine our new lagrange multipliers for 1 
			// (and sometimes 2)
			$a1 = $alpha1 - $score * ($a2 - $alpha2);
			if($a1 < 0) {
				$a2 += $score * $a1;
				$a1 = 0;
			} else if($a1 > self::UPPER_BOUND) {
				$a2 += $score * ($a1 - self::UPPER_BOUND);
				$a1 = self::UPPER_BOUND;
			}
			
			// Recalculate bias. 
			$b1 = $this->bias + $result1 + 
				$target1 * ($a1 - $alpha1) * $k11 + 
				$target2 * ($a2 - $alpha2) * $k12;
			$b2 = $this->bias + $result2 + 
				$target1 * ($a1 - $alpha1) * $k12 + 
				$target2 * ($a2 - $alpha2) * $k22;
			if($a1 > 0 && $a1 < self::UPPER_BOUND) {
				$newBias = $b1;	
			} else if($a2 > 0 && $a2 < self::UPPER_BOUND) {
				$newBias = $b2;	
			} else {
				$newBias = ($b1 + $b2) / 2;
			}
			
			$deltaBias = $newBias - $this->bias;
			$this->bias = $newBias;
			
			// Update the error cache for existing support vectors
			$t1 = $target1 * ($a1 - $alpha1);
			$t2 = $target2 * ($a2 - $alpha2);
			foreach($this->lagrangeMults as $id => $value) {
				if($value > 0 && $value < self::UPPER_BOUND) {
					$this->errorCache[$id] = 
						(isset($this->errorCache[$id]) ? $this->errorCache[$id] : 0) + (
						$t1 * $this->kernel($rowID, $id) + 
						$t2 * $this->kernel($otherRowID, $id)
						- $deltaBias);
				}
			}
			
			$this->errorCache[$rowID] = 0;
			$this->errorCache[$otherRowID] = 0;
			
			$this->lagrangeMults[$rowID] = $a1;
			$this->lagrangeMults[$otherRowID] = $a2;
			
			return 1;
		}
}