<?php
class Session {
    // Start Session
    public function startSession() {
        session_start();
        if (isset($_SESSION["logIn"])) {
            return true;
        } else {
            return false;
        }
    }
    // End Session
    public function endSession() {
        session_start();
        session_unset();
        session_destroy();
        if (!isset($_SESSION["logIn"])) {
            return true;
        } else {
            return false;
        }
    }
}
?>