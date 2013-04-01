<?php

//echo exec('svm-train jan.train jan.train.model');
echo exec('svm-predict jan.test jan.train.model jan.out');
//echo exec('svm_multiclass_classify test.dat model predictions');
?>