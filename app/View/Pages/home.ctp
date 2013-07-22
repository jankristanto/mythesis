<script type="text/javascript">
	$(document).ready(function(){
		$("#j-home").addClass("active");
	});
</script>
<!-- Jumbotron -->
<div class="jumbotron">
	<h1>Sentiment Analysis</h1>
	<p class="lead">Twitter Sentiment Analysis dengan menggunakan metode gabungan Lexicon Based dan Support Vector Machine</p>
	<a href="<?php echo $this->Html->url(array('controller' => 'hunts','action' => 'index'));?>" class="btn btn-large btn-success">Klik Disini Untuk Mencoba</a>
</div>

<hr>

<!-- Example row of columns -->
<div class="row-fluid">
	<div class="span4">
		<h2>Service</h2>
		<p>Anda dapat memasukan kata kunci yang anda ingin ketahui sentimennya. 
		Sistem akan mencari pada Twitter,tweets yang mengandung kata kunci seperti yang
		anda masukan, kemudian sistem akan menganalisis tweets yang ditemukan.
		</p>
		<p><a href="<?php echo $this->Html->url(array('controller' => 'hunts','action' => 'index'));?>" class="btn">View details</a></p>
	</div>
	<div class="span4">
		<h2>Comparison</h2>
		<p>Anda dapat melihat perbandingan antara penentuan sentimen dengan metode emoticon dan metode lexicon based. 
		</p>
		<p><a href="<?php echo $this->Html->url(array('controller' => 'pages','action' => 'summary','my'));?>" class="btn">View details</a></p>
		<p>Anda dapat melihat perbandingan antara penentuan sentimen dengan metode SVM dan dengan cara manual. 
		</p>
		<p><a href="<?php echo $this->Html->url(array('controller' => 'CleanTweets','action' => 'statistik'));?>" class="btn">View details</a></p>
	</div>
	<div class="span4">
		<h2>Test</h2>
		<p>Anda dapat melakukan pengujian dengan memasukan kalimat yang akan anda uji.</p>
		<p><a href="<?php echo $this->Html->url(array('controller' => 'Pages','action' => 'testLexiconBased'));?>" class="btn">Menguji Lexicon Based</a></p>
		<p><a href="<?php echo $this->Html->url(array('controller' => 'Pages','action' => 'testSvm'));?>" class="btn">Menguji Lexicon Based & SVM </a></p>
	</div>
</div>