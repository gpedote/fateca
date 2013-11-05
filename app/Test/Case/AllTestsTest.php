<?php
class AllTests extends CakeTestSuite {
    public static function suite() {
        $suite = new CakeTestSuite('All tests');
        //temporary until have true tests
        //$suite->addTestDirectoryRecursive(TESTS . 'Case');
        $suite->addTestDirectory(TESTS . 'Case' . DS . 'Controller');
        return $suite;
    }
}