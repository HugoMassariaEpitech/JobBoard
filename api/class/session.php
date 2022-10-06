<?php
class Session {
    // Start Session
    public function startSession() {
        if (isset($_COOKIE["jwt"])) {

            $headers = apache_request_headers();
            $tokenParts = explode(".", str_replace("Bearer ", "", $headers["Authorization"]));
            $payload = base64_decode($tokenParts[1]);
            $signature = hash_hmac("sha256", $tokenParts[0] . "." . $tokenParts[1], "90zgLEniSbKFrV6OJjVa825KcTI1JC7m", true);
            $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));
            if($payload == ""){
                return false;
            }
            else{
                return true;
            }
        } else {
            return false;
        }
    }
    // End Session
    public function endSession() {
        if (isset($_COOKIE['jwt'])) {
            unset($_COOKIE['jwt']);
            setcookie("jwt", time() - 3600);
            return true;
        } else {
            return false;
        }
    }
}
?>