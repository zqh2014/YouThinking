<?php

namespace qcloudcos;

class Conf {
    // Cos php sdk version number.
    const VERSION = 'v4.2.1';
    const API_COSAPI_END_POINT = 'http://region.file.myqcloud.com/files/v2/';

    // Please refer to http://console.qcloud.com/cos to fetch your app_id, secret_id and secret_key.
    const APP_ID = '1252171157';
    const SECRET_ID = 'AKIDGOK4dzb9yb3DeybAD5nMjuthJsJaxaLw';
    const SECRET_KEY = 'Xs25yiLqEaqxBE5oPqLgvypTwC80iFaJ';

    /**
     * Get the User-Agent string to send to COS server.


     */
    public static function getUserAgent() {
        return 'cos-php-sdk-' . self::VERSION;
    }
}
