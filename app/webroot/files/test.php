<?php
// outputs the username that owns the running php/httpd process
// (on a system with the "whoami" executable in the path)
//svm_multiclass_learn -c 5000 example4/train.dat example4/model
//svm_multiclass_classify example4/test.dat example4/model example4/predictions
//echo exec('svm_multiclass_classify example4/test.dat example4/model example4/predictions');
echo exec('svm_multiclass_learn -c 1000000 -e 0.1 train.dat model');
//echo exec('svm_multiclass_classify test.dat model predictions');
?>