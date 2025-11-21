<?php

namespace MiniOrange\TwoFA\Helper;

class AESEncryption
{
    public static function encrypt_data($H2Z4q, $svTke)
    {
        $g2YQw = '';
        $tfdm9 = 0;
        e3LC_:
        if (!($tfdm9 < strlen($H2Z4q))) {
            goto pZfqL;
        }
        $sgsTA = substr($H2Z4q, $tfdm9, 1);
        if (!(strlen($svTke) > 1)) {
            goto X_dQW;
        }
        $ehmkQ = substr($svTke, $tfdm9 % strlen($svTke) - 1, 1);
        $sgsTA = chr(ord($sgsTA) + ord($ehmkQ));
        $g2YQw .= $sgsTA;
        X_dQW:
        GCmTH:
        $tfdm9++;
        goto e3LC_;
        pZfqL:
        return base64_encode($g2YQw);
    }
    public static function decrypt_data($H2Z4q, $svTke)
    {
        $g2YQw = '';
        if (!is_null($H2Z4q)) {
            goto tckPZ;
        }
        $H2Z4q = '';
        goto m0FS0;
        tckPZ:
        $H2Z4q = base64_decode((string) $H2Z4q);
        m0FS0:
        $tfdm9 = 0;
        OY6VV:
        if (!($tfdm9 < strlen($H2Z4q))) {
            goto arpYr;
        }
        $sgsTA = substr($H2Z4q, $tfdm9, 1);
        if (!(strlen($svTke) > 1)) {
            goto wqY0G;
        }
        $ehmkQ = substr($svTke, $tfdm9 % strlen($svTke) - 1, 1);
        $sgsTA = chr(ord($sgsTA) - ord($ehmkQ));
        $g2YQw .= $sgsTA;
        wqY0G:
        ExE4d:
        $tfdm9++;
        goto OY6VV;
        arpYr:
        return $g2YQw;
    }
}