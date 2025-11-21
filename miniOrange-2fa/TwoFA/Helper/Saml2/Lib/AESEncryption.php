<?php

namespace MiniOrange\TwoFA\Helper\Saml2\Lib;

class AESEncryption
{
    public static function encrypt_data($MJHut, $iCyHG)
    {
        $V_qHC = '';
        $E_hLB = 0;
        zcgkr:
        if (!($E_hLB < strlen($MJHut))) {
            goto FDn5r;
        }
        $Lveql = substr($MJHut, $E_hLB, 1);
        $W48Sz = substr($iCyHG, $E_hLB % strlen($iCyHG) - 1, 1);
        $Lveql = chr(ord($Lveql) + ord($W48Sz));
        $V_qHC .= $Lveql;
        qSRVY:
        $E_hLB++;
        goto zcgkr;
        FDn5r:
        return base64_encode($V_qHC);
    }
    public static function decrypt_data($MJHut, $iCyHG)
    {
        $V_qHC = '';
        $MJHut = base64_decode((string) $MJHut);
        $E_hLB = 0;
        p0yAk:
        if (!($E_hLB < strlen($MJHut))) {
            goto gBgkn;
        }
        $Lveql = substr($MJHut, $E_hLB, 1);
        $W48Sz = substr($iCyHG, $E_hLB % strlen($iCyHG) - 1, 1);
        $Lveql = chr(ord($Lveql) - ord($W48Sz));
        $V_qHC .= $Lveql;
        UhWjS:
        $E_hLB++;
        goto p0yAk;
        gBgkn:
        return $V_qHC;
    }
}