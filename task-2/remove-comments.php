<?php

/**
 *  In this program we try to remove different kinds of comments
 */

class ThreeKindsOfComments {
    /**
     * @param int $a
     * @return int
     */
    function getText(int $a):int{
        if($a > 5 /** Interestingly this comment is not preserved by the parser*/){
            return 5;
        }
        return $a; //inline comments
        #return $a;
        /**
         * Unreachable code.
         */
    }
}
