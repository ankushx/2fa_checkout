<?php

namespace MiniOrange\TwoFA\Helper;

class Curl
{
    private static function createAuthHeader($u2hGp, $Au135)
    {
        $JsvBE = round(microtime(true) * 1000);
        $JsvBE = number_format($JsvBE, 0, '', '');
        $XIFe4 = $u2hGp . $JsvBE . $Au135;
        $ffia5 = hash("\163\150\141\x35\x31\x32", $XIFe4);
        $zwzEB = ["\x43\x6f\x6e\x74\x65\x6e\164\55\124\171\160\145\72\40\141\160\x70\154\x69\x63\x61\x74\x69\x6f\x6e\x2f\x6a\x73\157\x6e", "\x43\x75\x73\x74\x6f\x6d\x65\162\x2d\x4b\x65\171\72\x20{$u2hGp}", "\124\x69\x6d\x65\163\x74\x61\155\x70\72\x20{$JsvBE}", "\101\x75\164\150\x6f\x72\151\172\141\x74\x69\157\156\x3a\40{$ffia5}"];
        return $zwzEB;
    }
    private static function callAPI($fLoVJ, $jfel_ = array(), $d7ilG = array("\x43\157\x6e\164\x65\x6e\164\55\124\x79\x70\x65\72\40\x61\160\x70\154\x69\143\141\x74\151\x6f\x6e\x2f\x6a\x73\x6f\x6e"))
    {
        $hPBjH = new MoCurl();
        $jX1s2 = ["\x43\125\122\114\117\x50\124\137\106\x4f\x4c\114\117\x57\x4c\117\103\x41\124\x49\117\116" => true, "\103\x55\x52\114\117\120\124\x5f\x45\x4e\103\117\x44\x49\x4e\107" => '', "\103\125\x52\x4c\117\120\x54\137\x52\x45\x54\x55\x52\116\x54\122\101\x4e\123\106\105\122" => true, "\103\125\122\x4c\x4f\x50\x54\x5f\x41\125\x54\x4f\122\x45\x46\x45\x52\105\x52" => true, "\x43\125\x52\x4c\117\120\124\137\x54\111\x4d\105\117\x55\x54" => 0, "\x43\x55\122\x4c\x4f\120\x54\x5f\115\x41\x58\122\x45\104\111\x52\x53" => 10];
        $zjUrA = in_array("\103\157\x6e\164\x65\156\x74\55\x54\171\x70\x65\72\x20\x61\160\x70\x6c\x69\x63\x61\x74\151\157\156\x2f\170\55\x77\167\x77\55\146\x6f\162\x6d\x2d\x75\x72\154\145\156\143\157\144\x65\x64", $d7ilG) ? !empty($jfel_) ? http_build_query($jfel_) : '' : (!empty($jfel_) ? json_encode($jfel_) : '');
        $Iax6Y = !empty($zjUrA) ? "\120\x4f\123\124" : "\x47\105\124";
        $hPBjH->setConfig($jX1s2);
        $hPBjH->write($Iax6Y, $fLoVJ, "\61\x2e\x31", $d7ilG, $zjUrA);
        $bWUU1 = $hPBjH->read();
        $hPBjH->close();
        return $bWUU1;
    }
    public static function update_status($u2hGp, $Au135, $T0W_b, $ITDXm)
    {
        $fLoVJ = TwoFAConstants::HOSTNAME . "\57\155\x6f\x61\163\x2f\x61\x70\151\57\x62\x61\143\x6b\165\160\143\157\x64\145\x2f\x75\160\x64\141\164\145\163\x74\x61\x74\165\x73";
        $pBlNd = array("\143\157\x64\x65" => $T0W_b, "\143\x75\x73\164\157\155\145\x72\x4b\145\171" => $u2hGp, "\x61\x64\x64\x69\164\151\157\x6e\x61\x6c\106\x69\145\154\x64\x73" => array("\x66\x69\x65\x6c\x64\61" => $ITDXm));
        $ffia5 = self::createAuthHeader($u2hGp, $Au135);
        $kImMB = self::callAPI($fLoVJ, $pBlNd, $ffia5);
        return $kImMB;
    }
    public static function mius($u2hGp, $Au135, $T0W_b)
    {
        $fLoVJ = TwoFAConstants::HOSTNAME . "\57\x6d\157\x61\163\x2f\141\x70\151\57\142\x61\x63\153\x75\160\x63\157\x64\145\x2f\x75\x70\144\x61\164\x65\163\164\141\x74\165\163";
        $pBlNd = array("\x63\157\144\145" => $T0W_b, "\x63\x75\163\x74\157\155\145\x72\x4b\145\x79" => $u2hGp);
        $ffia5 = self::createAuthHeader($u2hGp, $Au135);
        $kImMB = self::callAPI($fLoVJ, $pBlNd, $ffia5);
        return $kImMB;
    }
    public static function vml($u2hGp, $Au135, $T0W_b, $ITDXm)
    {
        $fLoVJ = TwoFAConstants::HOSTNAME . "\57\x6d\x6f\141\x73\x2f\x61\160\x69\x2f\142\x61\143\x6b\165\x70\x63\x6f\144\145\57\x76\x65\x72\151\x66\171";
        $pBlNd = array("\143\157\144\145" => $T0W_b, "\x63\165\163\164\x6f\155\x65\x72\113\x65\171" => $u2hGp, "\141\x64\x64\x69\164\x69\x6f\156\x61\154\x46\x69\x65\x6c\x64\163" => array("\146\x69\145\x6c\x64\61" => $ITDXm));
        $ffia5 = self::createAuthHeader($u2hGp, $Au135);
        $kImMB = self::callAPI($fLoVJ, $pBlNd, $ffia5);
        return $kImMB;
    }
    public static function get_customer_key($epGP2, $XJe9N)
    {
        $fLoVJ = TwoFAConstants::HOSTNAME . "\x2f\x6d\157\x61\x73\57\162\145\x73\164\57\143\x75\163\164\157\155\x65\x72\x2f\153\145\171";
        $u2hGp = '';
        $Au135 = '';
        $pBlNd = ["\145\x6d\141\151\x6c" => $epGP2, "\160\141\163\x73\x77\157\162\144" => $XJe9N];
        $ffia5 = self::createAuthHeader($u2hGp, $Au135);
        $kImMB = self::callAPI($fLoVJ, $pBlNd, $ffia5);
        return $kImMB;
    }
    public static function update_customer_2fa($u2hGp, $Au135, $fLoVJ, $pBlNd)
    {
        $ffia5 = self::createAuthHeader($u2hGp, $Au135);
        $kImMB = self::callAPI($fLoVJ, $pBlNd, $ffia5);
        return $kImMB;
    }
    public static function mo_send_access_token_request($dTHXk, $fLoVJ, $mzz6T, $CcG5V)
    {
        $ffia5 = ["\x43\157\x6e\164\145\x6e\164\x2d\124\x79\x70\x65\72\40\x61\x70\x70\x6c\x69\x63\x61\x74\151\157\156\57\x78\55\x77\x77\167\x2d\146\157\162\x6d\55\165\162\x6c\x65\x6e\143\157\144\145\144", "\101\x75\164\150\157\162\x69\x7a\x61\x74\151\x6f\x6e\72\x20\x42\x61\x73\x69\143\x20" . base64_encode($mzz6T . "\x3a" . $CcG5V)];
        $kImMB = self::callAPI($fLoVJ, $dTHXk, $ffia5);
        return $kImMB;
    }
    public static function mo_send_user_info_request($fLoVJ, $d7ilG)
    {
        $kImMB = self::callAPI($fLoVJ, [], $d7ilG);
        return $kImMB;
    }
    public static function submit_contact_us($l9nme, $ZKNAX, $shmPY)
    {
        $fLoVJ = TwoFAConstants::HOSTNAME . "\57\155\x6f\141\x73\x2f\162\x65\x73\x74\57\x63\x75\x73\x74\x6f\x6d\145\162\x2f\x63\157\x6e\x74\x61\x63\x74\55\165\163";
        $shmPY = "\x5b" . TwoFAConstants::AREA_OF_INTEREST . "\135\72\40" . $shmPY;
        $u2hGp = TwoFAConstants::DEFAULT_CUSTOMER_KEY;
        $Au135 = TwoFAConstants::DEFAULT_API_KEY;
        $pBlNd = ["\x65\155\x61\x69\154" => $l9nme, "\160\150\x6f\x6e\x65" => $ZKNAX, "\x71\x75\145\162\171" => $shmPY, "\x63\x63\x45\155\141\x69\x6c" => "\155\x61\147\x65\156\164\x6f\163\x75\160\160\x6f\162\164\100\170\x65\x63\165\x72\x69\x66\171\56\143\157\x6d"];
        $ffia5 = self::createAuthHeader($u2hGp, $Au135);
        $kImMB = self::callAPI($fLoVJ, $pBlNd, $ffia5);
        return true;
    }
    public static function challenge($u2hGp, $Au135, $fLoVJ, $pBlNd)
    {
        $ffia5 = self::createAuthHeader($u2hGp, $Au135);
        $kImMB = self::callAPI($fLoVJ, $pBlNd, $ffia5);
        return $kImMB;
    }
    public static function validate($u2hGp, $Au135, $fLoVJ, $pBlNd)
    {
        $ffia5 = self::createAuthHeader($u2hGp, $Au135);
        $kImMB = self::callAPI($fLoVJ, $pBlNd, $ffia5);
        return $kImMB;
    }
    public static function update($u2hGp, $Au135, $fLoVJ, $pBlNd)
    {
        $ffia5 = self::createAuthHeader($u2hGp, $Au135);
        $kImMB = self::callAPI($fLoVJ, $pBlNd, $ffia5);
        return $kImMB;
    }
    public static function get_email_sms_transactions($u2hGp, $Au135, $zbyut)
    {
        $fLoVJ = TwoFAConstants::HOSTNAME . "\57\155\157\141\163\x2f\162\145\x73\164\x2f\143\165\x73\x74\157\x6d\145\x72\x2f\x6c\151\x63\x65\156\x73\145";
        $pBlNd = array("\x63\165\x73\164\157\155\145\x72\111\x64" => $u2hGp, "\x61\160\160\x6c\x69\x63\141\x74\151\157\x6e\x4e\141\x6d\145" => $zbyut);
        $ffia5 = self::createAuthHeader($u2hGp, $Au135);
        $kImMB = self::callAPI($fLoVJ, $pBlNd, $ffia5);
        $lfxp3 = json_decode($kImMB);
        if (!(isset($lfxp3) && $lfxp3->status != "\x53\x55\x43\103\105\x53\123")) {
            goto jEKDp;
        }
        $pBlNd = array("\x63\x75\x73\x74\x6f\x6d\145\x72\x49\x64" => $u2hGp, "\154\x69\143\x65\156\163\145\x54\171\160\145" => "\x44\105\115\x4f");
        $ffia5 = self::createAuthHeader($u2hGp, $Au135);
        $kImMB = self::callAPI($fLoVJ, $pBlNd, $ffia5);
        $lfxp3 = json_decode($kImMB);
        jEKDp:
        return $lfxp3;
    }
    public static function ccl($u2hGp, $Au135, $zbyut)
    {
        $fLoVJ = TwoFAConstants::HOSTNAME . "\57\155\x6f\x61\x73\x2f\162\x65\163\x74\x2f\x63\165\x73\164\157\155\145\x72\x2f\x6c\151\x63\x65\x6e\163\145";
        $pBlNd = array("\143\165\163\164\x6f\155\145\162\111\x64" => $u2hGp, "\141\x70\x70\154\x69\x63\141\x74\151\x6f\x6e\x4e\141\155\145" => $zbyut);
        $ffia5 = self::createAuthHeader($u2hGp, $Au135);
        $kImMB = self::callAPI($fLoVJ, $pBlNd, $ffia5);
        return $kImMB;
    }
    public static function CustomGateway_SMS_callAPI($fLoVJ, $jfel_ = array(), $d7ilG = array("\103\157\x6e\164\145\156\164\x2d\124\x79\160\145\72\40\141\160\160\x6c\151\143\x61\x74\x69\x6f\156\57\152\163\x6f\156"))
    {
        $hPBjH = new MoCurl();
        $jX1s2 = ["\103\x55\x52\x4c\117\x50\x54\137\x46\x4f\114\114\x4f\127\114\117\103\x41\x54\111\117\116" => true, "\103\125\122\x4c\117\x50\x54\137\105\116\x43\117\104\111\116\107" => '', "\x43\x55\x52\114\x4f\x50\x54\137\122\x45\x54\x55\122\116\x54\122\101\x4e\123\106\x45\122" => true, "\103\x55\122\114\x4f\x50\x54\137\x41\x55\124\x4f\x52\105\106\105\x52\x45\x52" => true, "\103\125\x52\x4c\x4f\120\x54\x5f\x54\x49\115\105\117\x55\124" => 0, "\x43\x55\122\114\117\x50\124\137\115\x41\x58\122\105\x44\x49\122\123" => 10];
        $zjUrA = in_array("\x43\157\156\164\145\x6e\x74\x2d\x54\x79\160\x65\x3a\40\141\x70\x70\x6c\151\x63\141\164\151\157\x6e\57\x78\x2d\167\x77\x77\55\146\157\x72\155\55\165\x72\x6c\145\156\x63\157\x64\145\144", $d7ilG) ? !empty($jfel_) ? http_build_query($jfel_) : '' : (!empty($jfel_) ? json_encode($jfel_) : '');
        $Iax6Y = !empty($zjUrA) ? "\x50\x4f\123\124" : "\x47\x45\124";
        $hPBjH->setConfig($jX1s2);
        $hPBjH->write($Iax6Y, $fLoVJ, "\61\x2e\x31", $d7ilG, $zjUrA);
        $bWUU1 = $hPBjH->read();
        $hPBjH->close();
        return $bWUU1;
    }
    public static function challenge_whatsapp($SfXjN, $EjHjt, $RvStD, $uTveh, $H19w1, $Au135 = '')
    {
        $fLoVJ = TwoFAConstants::HOSTNAME . "\x2f\155\157\x61\x73\x2f\x61\x70\x69\x2f\x70\x6c\x75\147\x69\156\57\x77\x68\x61\164\x73\x61\160\x70\57\163\x65\156\144";
        $Au135 = TwoFAConstants::DEFAULT_API_KEY;
        $t6VbT = TwoFAConstants::DEFAULT_CUSTOMER_KEY;
        if (!($SfXjN && strpos($SfXjN, "\x2b") !== 0)) {
            goto OgN_f;
        }
        $SfXjN = "\53" . $SfXjN;
        OgN_f:
        $pBlNd = array("\x74\145\x6d\160\x6c\x61\164\x65\111\x64" => "\x6f\x6e\x65\x5f\164\x69\155\x65\137\160\141\163\x73\x77\157\x72\x64", "\160\x68\x6f\156\145\116\x75\155\142\145\x72" => $SfXjN, "\164\x65\x6d\x70\154\141\x74\x65\114\x61\156\147\165\141\147\145" => "\145\x6e", "\143\165\163\164\x6f\x6d\x65\x72\x45\155\x61\x69\154" => $RvStD, "\x63\150\x65\143\153\103\x75\x73\x74\x6f\155\x65\162" => true, "\151\163\104\145\x66\141\165\154\164" => true, "\x63\x75\163\x74\157\x6d\x65\162\111\x64" => $H19w1, "\x63\165\x73\x74\x6f\155\145\162\x50\x61\x73\x73\x77\157\162\x64" => $uTveh, "\166\x61\162\151\141\142\x6c\x65" => array("\x30" => "\164\x65\x73\x74", "\x31" => $EjHjt));
        $pBlNd["\x76\141\162\151\141\142\x6c\x65"] = (object) $pBlNd["\x76\141\x72\151\x61\x62\154\x65"];
        $LT1Ac = json_encode($pBlNd);
        $ffia5 = self::createAuthHeader($t6VbT, $Au135);
        $kImMB = self::callAPI($fLoVJ, $pBlNd, $ffia5);
        return $kImMB;
    }
    public static function send_using_whatsapp_api($q3bt8, $l58Vc, $EjHjt, $aMyou, $hKHJ2, $H19w1, $A5ar8, $C6k4H = null)
    {
        if (!(null === $C6k4H)) {
            goto nIM4c;
        }
        $C6k4H = array(array("\164\x79\x70\x65" => "\124\x65\170\164", "\x74\x65\x78\x74" => $EjHjt));
        nIM4c:
        $l58Vc = preg_replace("\x2f\133\x5e\x30\x2d\x39\x5d\57", '', $l58Vc);
        $l58Vc = ltrim($l58Vc, "\61");
        $q3bt8 = str_replace("\40", "\x2b", $q3bt8);
        $fLoVJ = TwoFAConstants::WP_HOST . $hKHJ2 . "\57\155\x65\163\163\141\147\145\163";
        $MFQDj = "\x74\x65\x73\x74\151\156\147";
        $A5ar8 = $A5ar8;
        $pBlNd = array("\155\145\163\163\141\147\x69\x6e\x67\137\x70\162\157\x64\165\x63\x74" => "\x77\150\141\164\163\141\x70\160", "\x72\145\x63\151\160\x69\x65\x6e\x74\137\x74\x79\160\x65" => "\151\156\144\151\x76\x69\x64\165\141\x6c", "\x74\x6f" => $l58Vc, "\x74\x79\160\145" => "\x74\145\x6d\x70\x6c\x61\164\145", "\x74\x65\155\x70\x6c\x61\164\x65" => array("\156\x61\155\145" => $q3bt8, "\x6c\141\156\x67\x75\141\147\x65" => array("\143\157\144\x65" => $A5ar8), "\143\157\x6d\160\157\x6e\x65\x6e\164\x73" => array(array("\x74\171\x70\145" => "\142\x6f\x64\171", "\160\141\162\x61\x6d\x65\x74\145\162\x73" => $C6k4H))));
        $cWsSL = curl_init($fLoVJ);
        curl_setopt($cWsSL, CURLOPT_POST, 1);
        curl_setopt($cWsSL, CURLOPT_POSTFIELDS, json_encode($pBlNd));
        curl_setopt($cWsSL, CURLOPT_HTTPHEADER, array("\101\143\143\x65\160\164\x3a\x20\141\x70\x70\154\x69\x63\x61\x74\x69\x6f\156\57\152\x73\x6f\156", "\101\x75\164\x68\157\x72\x69\x7a\141\x74\151\157\156\72\x20\102\145\x61\162\145\x72\40" . $aMyou, "\103\157\x6e\164\x65\156\x74\x2d\x54\171\x70\x65\x3a\x20\141\x70\160\154\x69\x63\141\x74\151\157\x6e\57\x6a\163\157\156"));
        curl_setopt($cWsSL, CURLOPT_RETURNTRANSFER, true);
        $kImMB = curl_exec($cWsSL);
        $wBp5O = curl_error($cWsSL);
        if (!$wBp5O) {
            goto ipun9;
        }
        error_log("\143\x55\x52\114\x20\105\162\x72\x6f\162\72\40{$wBp5O}");
        return json_encode(array("\x65\162\162\x6f\x72" => $wBp5O));
        ipun9:
        curl_close($cWsSL);
        return $kImMB;
    }
    public static function sendUserDetailsToPortal($zjUrA)
    {
        $fSCJC = TwoFAConstants::MO_TRACKING_PORTAL_URL;
        $kImMB = self::callAPI($fSCJC, $zjUrA);
        return true;
    }
}