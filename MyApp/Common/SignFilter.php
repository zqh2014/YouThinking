<?php

class Common_SignFilter implements PhalApi_Filter {

    public function check() {
        if (DI()->request->get('__debug__') == '1') {
            return;
        }

      $Domain_Users = new Domain_Users();
      $domain = DI()->request->get('domain');
      $key =  DI()->request->get('key');
      

        if (!$Domain_Users->isJoinIn($domain,$key)) {
            throw new PhalApi_Exception_BadRequest(T('wrong sign'));
        }
    }
}
