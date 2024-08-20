<?php

trait TimestampTrait {
    public function getCurrentTimestamp() {
        return date('Y-m-d H:i:s');
    }
}
