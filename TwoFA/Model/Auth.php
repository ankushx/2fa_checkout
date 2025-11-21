<?php

namespace MiniOrange\TwoFA\Model;

use Exception;
use Magento\Backend\Helper\Data;
use Magento\Backend\Model\Auth\Credential\StorageInterface as CredentialStorageInterface;
use Magento\Backend\Model\Auth\StorageInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ActionFlag;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Data\Collection\ModelFactory;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\AuthenticationException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\Plugin\AuthenticationException as PluginAuthenticationException;
use Magento\Framework\HTTP\PhpEnvironment\Request;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Session\SessionManager;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\UrlInterface;
use MiniOrange\TwoFA\Helper\CustomEmail;
use MiniOrange\TwoFA\Helper\CustomSMS;
use MiniOrange\TwoFA\Helper\MiniOrangeUser;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
class Auth extends \Magento\Backend\Model\Auth
{
    protected $request;
    protected $_dateTime;
    protected $_url;
    protected $_response;
    protected $_storageSession;
    protected $actionFlag;
    protected $_helperData;
    protected $_isTrusted = false;
    protected $twofautility;
    protected $customEmail;
    protected $customSMS;
    protected $_request;
    protected $currentAdminUser;
    protected $isSandboxTrialEnabled;
    public function __construct(ManagerInterface $Fh1ml, Data $CXrkn, StorageInterface $lK25p, CredentialStorageInterface $Z9079, ScopeConfigInterface $RJjMs, ModelFactory $V2qp9, Request $ZcUrO, DateTime $hlrhm, UrlInterface $TpZZ3, ResponseInterface $tK27Y, SessionManager $LO1AH, ActionFlag $Ok7QK, TwoFAUtility $Z2LOY, RequestInterface $Uf1tc, CustomEmail $m3qtA, CustomSMS $j_5OM)
    {
        $this->request = $ZcUrO;
        $this->_dateTime = $hlrhm;
        $this->_url = $TpZZ3;
        $this->_response = $tK27Y;
        $this->_storageSession = $LO1AH;
        $this->actionFlag = $Ok7QK;
        $this->twofautility = $Z2LOY;
        $this->_request = $ZcUrO;
        $this->customEmail = $m3qtA;
        $this->customSMS = $j_5OM;
        parent::__construct($Fh1ml, $CXrkn, $lK25p, $Z9079, $RJjMs, $V2qp9);
    }
    public function login($N5AMO, $B0wtB)
    {
        $WnVEi = $this->_request->getParams();
        $this->isSandboxTrialEnabled = $this->twofautility->ifSandboxTrialEnabled();
        if (!(empty($N5AMO) || empty($B0wtB))) {
            goto Hk1IX;
        }
        self::throwException(__("\131\x6f\x75\x20\x64\x69\x64\40\x6e\157\x74\x20\163\151\x67\x6e\x20\151\156\x20\x63\157\162\162\145\x63\164\x6c\x79\x20\x6f\x72\x20\171\x6f\x75\x72\x20\x61\x63\x63\x6f\x75\156\x74\x20\151\163\40\164\145\155\160\157\162\x61\162\x69\154\171\x20\144\151\163\x61\142\x6c\x65\144\56"));
        Hk1IX:
        try {
            $this->twofautility->log_debug("\x41\165\x74\150\56\160\x68\x70\x20\72\x20\x65\x78\x65\143\x75\x74\x65\x20\x3a\141\x64\155\x69\x6e\40\x6c\x6f\x67\151\156\40\146\x6c\157\x77");
            $this->_initCredentialStorage();
            $this->getCredentialStorage()->login($N5AMO, $B0wtB);
            if (!$this->getCredentialStorage()->getId()) {
                goto GnGDd;
            }
            $user = $this->getCredentialStorage();
            $this->twofautility->setSessionValue("\x61\144\x6d\x69\156\137\x75\163\145\x72\137\x69\144", $user->getID());
            $this->actionFlag->set('', Action::FLAG_NO_DISPATCH, true);
            $this->_storageSession->setData("\x75\x73\145\162", $user);
            $ReBne = $user->getUsername();
            $vQ9fF = $user->getData();
            $wo9sh = $vQ9fF["\x65\x6d\141\x69\154"];
            $this->twofautility->setSessionValue("\141\x64\x6d\x69\156\137\x69\156\x6c\151\x6e\x65\137\145\155\141\x69\x6c\137\144\145\164\141\151\154", $wo9sh);
            $bRKhR = $this->twofautility->getAllMoTfaUserDetails("\155\x69\x6e\151\157\162\141\156\147\x65\x5f\x74\x66\141\137\x75\163\145\x72\163", $ReBne, -1);
            $oKusD = $this->twofautility->get_admin_role_name();
            if (!$this->twofautility->isTrialExpired()) {
                goto tjB6f;
            }
            $this->twofautility->log_debug("\101\165\164\150\56\160\150\x70\x3a\40\x65\170\145\x63\x75\x74\145\40\x3a\x20\131\x6f\165\162\x20\x64\x65\x6d\157\x20\x61\x63\143\x6f\165\x6e\x74\40\x68\141\x73\x20\x65\170\x70\151\162\x65\144\56");
            return $this->NormalLoginFlow();
            tjB6f:
            $aMmmU = $this->twofautility->getStoreConfig(TwoFAConstants::ADMIN_REMEMBER_DEVICE . $oKusD);
            if (!($aMmmU && !empty($bRKhR) && isset($bRKhR[0]["\x64\145\166\x69\x63\x65\x5f\151\x6e\146\x6f"]) && $bRKhR[0]["\144\x65\x76\151\143\x65\x5f\x69\x6e\x66\157"] != '')) {
                goto CEE8e;
            }
            $this->twofautility->log_debug("\x41\x75\164\x68\56\160\x68\x70\x20\72\40\111\156\163\151\x64\x65\x20\x64\145\x76\x69\x63\145\55\x62\141\163\145\x64\x20\162\x65\163\164\x72\151\143\x74\x69\157\x6e\x20\143\150\x65\143\x6b\x2e");
            $y0_Vc = json_decode($bRKhR[0]["\x64\x65\x76\151\143\145\137\x69\156\146\157"], true);
            if (!(is_array($y0_Vc) && !empty($y0_Vc))) {
                goto IwrQ9;
            }
            $this->twofautility->log_debug("\101\x75\x74\x68\56\160\x68\160\x20\72\40\111\156\163\x69\x64\145\40\144\145\x76\x69\143\145\55\142\x61\x73\145\144\x20\162\145\163\164\162\x69\143\x74\x69\157\x6e\x20\143\150\145\143\x6b\x2c\40\151\164\145\162\141\164\x69\x6e\x67\40\x74\150\x72\157\x75\x67\150\x20\163\x61\166\x65\144\40\x64\x65\x76\x69\143\x65\163\x2e");
            $nmjZK = $this->twofautility->getCurrentDeviceInfo();
            $nmjZK = json_decode($nmjZK, true);
            $oLZh4 = (int) $this->twofautility->getStoreConfig(TwoFAConstants::ADMIN_REMEMBER_DEVICE_LIMIT . $oKusD);
            $uHgv_ = date("\x59\x2d\x6d\x2d\x64");
            $this->twofautility->log_debug("\x41\165\164\150\x2e\x70\x68\x70\x20\x3a\40\104\x65\166\151\x63\x65\40\144\141\171\40\154\151\x6d\151\x74\72\x20" . $oLZh4);
            foreach ($y0_Vc as $uS1gY) {
                $Ze9Gv = true;
                $ul3ww = ["\x46\x69\156\x67\x65\x72\160\x72\x69\x6e\x74"];
                foreach ($ul3ww as $pieuk) {
                    if (!(!isset($uS1gY[$pieuk]) || !isset($nmjZK[$pieuk]) || $uS1gY[$pieuk] !== $nmjZK[$pieuk])) {
                        goto MhNAx;
                    }
                    $Ze9Gv = false;
                    goto khJ7E;
                    MhNAx:
                    Z6GgL:
                }
                khJ7E:
                if (!$Ze9Gv) {
                    goto DDpGB;
                }
                $rwgMc = "\x64\x65\166\x69\x63\145\137\151\156\146\157\137\x61\144\x6d\151\156\137" . hash("\x73\x68\x61\62\65\66", $ReBne);
                $MPFp2 = $_COOKIE[$rwgMc] ?? null;
                if (!($MPFp2 !== $uS1gY["\122\x61\x6e\144\x6f\155\137\x73\x74\162\x69\x6e\x67"])) {
                    goto XiLYP;
                }
                $this->twofautility->log_debug("\101\x75\164\150\56\160\150\x70\x20\72\40\143\x6f\157\x6b\151\x65\163\x20\144\157\x65\x73\x6e\x74\40\x6d\141\x74\x63\150\40\x77\151\x74\150\x20\x66\151\x6e\147\x65\162\160\162\151\x6e\164");
                $Ze9Gv = false;
                XiLYP:
                DDpGB:
                if (!$Ze9Gv) {
                    goto vMwwx;
                }
                $this->twofautility->log_debug("\101\x75\164\150\56\160\150\160\40\x3a\40\104\145\x76\x69\143\145\40\155\x61\x74\143\x68\145\163\72\40" . $Ze9Gv);
                $mebtp = $uS1gY["\x63\157\x6e\146\x69\x67\165\x72\x65\x64\x5f\144\141\x74\x65"];
                $M3Afk = (strtotime($uHgv_) - strtotime($mebtp)) / (60 * 60 * 24);
                if (!((int) $M3Afk < (int) $oLZh4)) {
                    goto ukyk1;
                }
                $this->twofautility->log_debug("\101\165\x74\150\56\160\150\x70\40\x3a\x20\104\x65\x76\151\x63\145\x20\x6d\141\x74\143\x68\x65\163\x20\141\x6e\144\40\162\145\155\x61\x69\x6e\x69\x6e\147\x20\144\141\x79\x73\40\x3c\x20\x64\145\166\x69\x63\145\40\144\141\x79\x20\x6c\151\155\151\x74\x2e\40\x44\145\166\x69\143\145\40\104\x61\171\x20\114\151\x6d\x69\x74\x3a\x20" . $oLZh4);
                $this->twofautility->log_debug("\x41\x75\x74\x68\56\x70\x68\160\40\72\x20\x44\x65\x76\x69\x63\145\40\155\141\x74\143\x68\145\163\x20\x61\x6e\144\x20\162\x65\x6d\x61\151\x6e\x69\x6e\147\x20\144\141\x79\163\40\x3c\40\144\x65\166\x69\x63\145\40\x64\141\x79\40\x6c\x69\155\x69\x74\x2e\40\122\145\x6d\x61\x69\x6e\x69\156\x67\x20\104\x61\x79\163\x3a\40" . $M3Afk);
                $this->twofautility->log_debug("\x41\x75\164\150\x2e\160\x68\x70\40\x3a\x20\104\145\x76\151\x63\145\x20\x6d\141\x74\x63\150\145\x73\40\x61\156\144\40\x72\x65\155\x61\151\156\151\x6e\x67\x20\x64\x61\x79\163\40\74\x20\x64\145\166\151\143\x65\40\x64\x61\x79\x20\154\151\x6d\x69\164\56\x20\x4c\x6f\147\147\x69\156\x67\x20\x69\156\40\x77\151\x74\x68\x6f\x75\x74\40\x32\106\101\x2e");
                return $this->NormalLoginFlow();
                ukyk1:
                goto DopaB;
                vMwwx:
                gsfI4:
            }
            DopaB:
            IwrQ9:
            CEE8e:
            $PB0If = $this->twofautility->getStoreConfig(TwoFAConstants::SKIP_TWOFA_ADMIN . $oKusD);
            if (!isset($PB0If)) {
                goto dIiLq;
            }
            $uYDL4 = $this->twofautility->getStoreConfig(TwoFAConstants::SKIP_TWOFA_DAYS_ADMIN . $oKusD);
            if (!(!empty($bRKhR) && isset($bRKhR[0]["\x73\153\151\x70\x5f\x74\167\x6f\146\141\137\160\162\x65\155\x61\156\145\156\164"]))) {
                goto m868o;
            }
            $XGIL_ = $bRKhR[0]["\x73\153\151\160\x5f\164\167\157\146\141\137\160\x72\x65\155\x61\156\x65\156\164"];
            if (!($XGIL_ == true)) {
                goto Kn8k7;
            }
            $this->twofautility->log_debug("\101\165\x74\150\x2e\x70\x68\160\40\72\x20\x65\170\x65\143\165\x74\x65\72\40\x70\x65\162\x6d\141\156\145\x6e\x74\x20\x73\153\151\x70\x20\145\156\x61\142\x6c\145\144\40\146\x6f\x72\40\x61\x64\x6d\x69\156\72" . $N5AMO);
            return $this->NormalLoginFlow();
            Kn8k7:
            m868o:
            if (!(!empty($bRKhR) && (isset($bRKhR[0]["\x73\x6b\151\x70\x5f\164\167\157\146\x61\x5f\x63\157\x6e\x66\151\147\x75\x72\x65\144\137\144\141\164\x65"]) && $bRKhR[0]["\x73\x6b\151\x70\137\164\167\x6f\146\141\x5f\143\157\156\146\x69\147\165\162\x65\144\137\144\x61\x74\x65"] != NULL))) {
                goto VkuGJ;
            }
            $CUokj = json_decode($bRKhR[0]["\x73\x6b\151\160\137\x74\x77\x6f\146\x61\137\143\157\156\x66\x69\x67\165\x72\x65\x64\x5f\x64\x61\x74\145"], true);
            $mebtp = $CUokj["\x63\157\x6e\x66\x69\147\165\x72\145\144\x5f\x64\141\x74\x65"];
            if (!($uYDL4 == "\x70\x65\x72\155\x61\156\x65\156\x74")) {
                goto ih1WU;
            }
            $this->twofautility->log_debug("\x41\165\164\x68\x2e\160\x68\x70\x20\72\40\x65\170\x65\x63\165\x74\145\72\40\160\x65\x72\155\141\x6e\145\x6e\x74\x20\163\153\151\160\40\145\x6e\x61\x62\x6c\145\144\x20\146\x6f\162\x20\141\x64\x6d\151\156\x3a" . $N5AMO);
            return $this->NormalLoginFlow();
            ih1WU:
            $uHgv_ = date("\131\55\x6d\x2d\144");
            $M3Afk = (strtotime($uHgv_) - strtotime($mebtp)) / (60 * 60 * 24);
            if (!($M3Afk < (int) $uYDL4)) {
                goto FVjgn;
            }
            $this->twofautility->log_debug("\x41\x75\x74\150\x2e\x70\150\160\x20\x3a\x20\x65\170\x65\x63\165\164\x65\72\x20\x73\153\x69\160\40\141\x64\x6d\151\156\x20\x64\x61\x79\x73\x20\154\145\x73\x73\x20\164\150\141\x6e\x20\x63\x6f\156\x66\x69\x67\165\x72\x65\144\x3a\x20\144\151\162\145\x63\164\x20\x6c\157\147\x69\x6e\x20\146\x6f\x72\40\141\144\155\x69\x6e\72" . $N5AMO);
            return $this->NormalLoginFlow();
            FVjgn:
            VkuGJ:
            dIiLq:
            $this->twofautility->flushCache();
            $ZlO4v = $this->twofautility->getGlobalConfig(TwoFAConstants::CURRENT_ADMIN_RULE);
            $eNY14 = $this->twofautility->ifSandboxTrialEnabled() ? "\x61\144\x6d\151\x6e\x5f\x61\x63\x74\151\166\145\x4d\145\x74\150\x6f\144\x73\x5f" . $oKusD . "\137" . $ReBne : "\x61\144\155\151\x6e\137\141\x63\x74\x69\166\145\115\x65\164\150\157\144\x73\x5f" . $oKusD;
            $gn_Rj = $this->twofautility->getStoreConfig($eNY14);
            $this->twofautility->log_debug("\114\157\x67\x69\x6e\120\x6f\x73\164\x2e\x70\x68\x70\40\72\x20\145\x78\x65\143\165\x74\x65\72\x20\147\x65\x74\x53\x74\x6f\x72\x65\x43\157\x6e\146\x69\147\40\141\x63\164\x69\x76\x65\x5f\x6d\145\x74\150\157\x64", $gn_Rj);
            $z4f9U = $gn_Rj == "\x5b\135" || $gn_Rj == NULL ? false : true;
            $this->twofautility->log_debug("\114\157\x67\x69\x6e\x50\157\x73\x74\56\x70\150\x70\x20\72\40\145\170\145\x63\165\164\x65\x3a\40\x61\143\x74\151\x76\x65\137\155\x65\x74\x68\157\144\137\x73\x74\x61\x74\165\x73", $z4f9U);
            $u3Ma2 = $this->twofautility->check2fa_backendPlan();
            $this->twofautility->log_debug("\114\x6f\x67\151\x6e\x50\x6f\163\164\x2e\160\x68\x70\40\72\x20\145\x78\145\143\x75\164\x65\x3a\x20\x63\x68\145\x63\x6b\x32\x66\141\x5f\142\x61\143\153\145\x6e\144\x50\154\141\156\x20\x74\167\157\146\x61\137\x65\156\164\x65\162\x70\x72\x69\163\145\x5f\x70\x6c\x61\x6e", $u3Ma2);
            $Sd1IT = NULL;
            if (!isset($WnVEi["\142\141\x63\153\x64\157\157\162"])) {
                goto Ym9n0;
            }
            $this->twofautility->log_debug("\x41\165\164\x68\x2e\x70\150\160\40\x3a\x20\145\170\145\x63\165\164\145\x3a\x20\142\141\143\153\x64\x6f\157\x72\x20\x6c\157\147\151\156\40\x6f\x66\x20\141\x64\x6d\151\156\x20\x73\145\x74");
            $Sd1IT = 1;
            Ym9n0:
            if ($ZlO4v && $z4f9U && $u3Ma2 && $Sd1IT == NULL && !$this->twofautility->checkTrustedIPs("\141\144\155\x69\156")) {
                goto DeBSM;
            }
            if ($Sd1IT) {
                goto ZiCdV;
            }
            $this->twofautility->log_debug("\101\x75\164\150\56\x70\150\x70\40\x3a\x20\145\170\x65\x63\165\x74\x65\72\x20\x6d\x6f\144\165\x6c\145\x20\144\x69\163\x61\x62\x6c\x65\x64");
            return $this->NormalLoginFlow();
            goto ew3Pp;
            DeBSM:
            $this->twofautility->log_debug("\101\x75\x74\x68\x2e\160\150\x70\40\72\x20\145\170\x65\x63\x75\164\x65\x3a\40\x6d\x6f\144\x75\x6c\x65\40\145\156\x61\x62\x6c\145\144");
            if (is_array($bRKhR) && sizeof($bRKhR) > 0 && (isset($bRKhR[0]["\x73\x6b\151\x70\137\x74\167\x6f\x66\141"]) && ($bRKhR[0]["\163\153\151\x70\x5f\164\x77\157\146\141"] == NULL || $bRKhR[0]["\163\x6b\151\x70\137\164\x77\157\146\141"] == ''))) {
                goto tCvve;
            }
            $this->twofautility->log_debug("\101\165\164\150\x2e\x70\x68\x70\40\72\40\x65\x78\145\x63\x75\164\145\x3a\40\141\144\155\151\x6e\40\147\x6f\151\x6e\147\40\x74\x68\x72\157\x75\147\x68\40\x61\x64\155\x69\156\40\x69\156\154\151\156\x65\40\x70\x72\157\x63\145\x73\163");
            $this->twofautility->setSessionValue("\141\x64\155\x69\156\x5f\145\155\141\151\154", NULL);
            $this->twofautility->setSessionValue("\141\144\155\x69\x6e\137\x70\150\157\156\145", NULL);
            $this->twofautility->setSessionValue("\x61\x64\155\151\156\x5f\143\x6f\x75\156\x74\162\x79\143\x6f\x64\x65", NULL);
            $this->twofautility->setSessionValue("\x61\x64\155\151\x6e\x5f\151\x73\151\x6e\154\151\156\x65", 1);
            $this->twofautility->setSessionValue("\x61\x64\x6d\151\156\137\163\x65\143\162\145\164", $this->twofautility->generateRandomString());
            $this->twofautility->setSessionValue("\141\x64\155\x69\156\137\x61\143\x74\151\166\x65\x5f\x6d\x65\164\150\x6f\x64", NULL);
            $this->twofautility->setSessionValue("\x61\144\x6d\x69\x6e\137\143\157\x6e\146\151\x67\x5f\155\x65\x74\x68\x6f\144", NULL);
            $this->twofautility->setSessionValue("\x61\x64\155\151\x6e\137\164\162\x61\156\163\x61\143\164\151\157\x6e\151\x64", NULL);
            $this->twofautility->setSessionValue("\x61\x64\155\x69\x6e\x5f\x75\163\x65\x72\x6e\141\155\145", $N5AMO);
            $oKusD = $this->twofautility->get_admin_role_name();
            $BzF_N = $this->isSandboxTrialEnabled ? TwoFAConstants::NUMBER_OF_ADMIN_METHOD . $oKusD . "\x5f" . $N5AMO : TwoFAConstants::NUMBER_OF_ADMIN_METHOD . $oKusD;
            $ziwA6 = $this->isSandboxTrialEnabled ? TwoFAConstants::ADMIN_ACTIVE_METHOD_INLINE . $oKusD . "\x5f" . $N5AMO : TwoFAConstants::ADMIN_ACTIVE_METHOD_INLINE . $oKusD;
            $zQkOF = $this->twofautility->getStoreConfig($BzF_N);
            if ($zQkOF == 1) {
                goto gkFmS;
            }
            if ($zQkOF > 1) {
                goto MUfcB;
            }
            if ($zQkOF == NULL) {
                goto ykLcx;
            }
            goto VbFca;
            gkFmS:
            $eNY14 = $this->twofautility->getStoreConfig($ziwA6);
            $eNY14 = trim($eNY14, "\133\x22\x22\135");
            $TpZZ3 = $this->_url->getUrl("\155\157\x74\167\x6f\x66\x61\x2f\x6f\x74\x70\57\141\x75\x74\150\x70\x6f\163\164");
            $TpZZ3 = $TpZZ3 . "\x3f\x26\143\x68\x6f\x6f\x73\145\x5f\x6d\x65\164\x68\157\x64\x3d\61\x26\123\x61\x76\x65\75\x53\141\166\145\46\x73\x74\x65\x70\163\75" . $eNY14 . "\46\145\155\x61\151\x6c\x3d" . $wo9sh;
            $this->_response->setRedirect($TpZZ3);
            goto VbFca;
            MUfcB:
            $TpZZ3 = $this->_url->getUrl("\x6d\157\x74\x77\157\x66\x61\x2f\x6f\164\x70\57\x61\x75\x74\x68\x69\156\144\x65\170");
            $TpZZ3 = $TpZZ3 . "\x3f\x26\163\164\145\x70\x73\x3d\143\x68\x6f\157\163\145\x6d\145\x74\x68\x6f\144\46\145\155\141\151\x6c\x3d" . $wo9sh;
            $this->_response->setRedirect($TpZZ3);
            goto VbFca;
            ykLcx:
            return $this->NormalLoginFlow();
            VbFca:
            goto MtKhY;
            tCvve:
            if (!$this->check_2fa_disable($bRKhR)) {
                goto xO2JM;
            }
            return $this->NormalLoginFlow();
            xO2JM:
            $this->twofautility->log_debug("\x41\165\x74\x68\56\160\x68\160\x20\72\x20\145\170\145\143\x75\x74\x65\72\40\141\x64\155\x69\x6e\x20\x68\141\x73\x20\x61\154\x72\x65\141\x64\x79\40\163\x65\164\40\124\167\157\106\101\x20\x73\145\164\x74\x69\156\147\163");
            $bfwTr = $bRKhR[0]["\x61\x63\164\x69\x76\x65\137\155\x65\x74\x68\x6f\x64"];
            if (!("\x47\157\157\x67\x6c\145\101\165\x74\x68\x65\156\x74\151\x63\141\x74\157\162" != $bfwTr && "\115\x69\x63\162\x6f\x73\157\146\164\x41\x75\164\x68\x65\156\164\151\x63\x61\164\157\162" != $bfwTr)) {
                goto Alnzt;
            }
            $this->twofautility->log_debug("\101\x75\x74\x68\x2e\160\150\160\40\72\40\x65\170\x65\143\165\164\x65\x3a\40\x41\x63\x74\x69\x76\145\x20\x6d\x65\164\150\157\144\40\x66\x6f\165\156\x64\72" . $bfwTr);
            $vFC5a = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
            $oHHrs = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
            $QsM3i = $this->twofautility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);
            if ($vFC5a || $oHHrs) {
                goto sKyvT;
            }
            if ($bfwTr == "\x4f\x4f\x57") {
                goto y62iE;
            }
            $JOlt4 = new MiniOrangeUser();
            $tK27Y = json_decode($JOlt4->challenge_admin($ReBne, $this->twofautility, $bfwTr, true, -1));
            $UWh2h = array("\163\164\141\x74\165\163" => $tK27Y->status, "\155\145\x73\163\x61\147\145" => $tK27Y->message, "\164\x78\111\x64" => $tK27Y->txId ?? '');
            if (!($UWh2h["\x73\x74\x61\x74\165\x73"] === "\x53\125\x43\x43\105\x53\x53")) {
                goto YD1Tt;
            }
            $this->twofautility->log_debug("\x41\x75\x74\x68\x2e\160\x68\x70\x20\x3a\40\117\x74\x70\x20\163\145\x6e\x64\40\x73\165\x63\143\x65\x73\146\x75\x6c\x6c\x79");
            $this->twofautility->updateColumnInTable("\x6d\151\x6e\x69\157\x72\x61\156\147\x65\x5f\x74\146\141\137\x75\163\x65\x72\163", "\164\x72\x61\x6e\x73\x61\x63\x74\x69\157\156\x49\144", $UWh2h["\164\170\x49\x64"] ?? '', "\165\x73\x65\x72\156\x61\155\x65", $ReBne, -1);
            YD1Tt:
            goto xW4AF;
            y62iE:
            if ($bfwTr == "\117\117\127" && $QsM3i) {
                goto EjJhq;
            }
            if ($bfwTr == "\x4f\117\x57") {
                goto xD_Rf;
            }
            goto iXbKM;
            EjJhq:
            $cRCDf = $this->twofautility->Customgateway_GenerateOTP();
            $iid2N = $bRKhR[0]["\160\150\x6f\x6e\x65"];
            $ZHFok = $bRKhR[0]["\143\x6f\165\x6e\x74\x72\x79\x63\157\144\145"];
            $iid2N = "\53" . $ZHFok . $iid2N;
            $UWh2h = $this->twofautility->send_customgateway_whatsapp($iid2N, $cRCDf);
            goto iXbKM;
            xD_Rf:
            $cRCDf = $this->twofautility->Customgateway_GenerateOTP();
            $iid2N = $bRKhR[0]["\x70\x68\157\x6e\145"];
            $ZHFok = $bRKhR[0]["\x63\157\165\x6e\x74\162\x79\x63\157\144\145"];
            $iid2N = "\x2b" . $ZHFok . $iid2N;
            $UWh2h = $this->twofautility->send_whatsapp($iid2N, $cRCDf);
            iXbKM:
            xW4AF:
            goto xegbf;
            sKyvT:
            $this->twofautility->log_debug("\101\x75\x74\150\x2e\160\x68\160\40\x3a\x20\145\x78\x65\143\x75\x74\145\x3a\x20\x43\x75\163\x74\157\x6d\40\147\141\164\x65\x77\x61\171");
            if ($bfwTr == "\117\117\105" && $vFC5a) {
                goto GRE5t;
            }
            if ($bfwTr == "\117\x4f\105") {
                goto aIMfR;
            }
            goto TnKQe;
            GRE5t:
            $to1Xj = $this->twofautility->Customgateway_GenerateOTP();
            $DOL2_ = $wo9sh;
            $UWh2h = $this->customEmail->sendCustomgatewayEmail($DOL2_, $to1Xj);
            goto TnKQe;
            aIMfR:
            $JOlt4 = new MiniOrangeUser();
            $tK27Y = json_decode($JOlt4->challenge_admin($ReBne, $this->twofautility, $bfwTr, true, -1));
            $UWh2h = array("\x73\164\x61\x74\x75\163" => $tK27Y->status, "\x6d\145\163\163\141\x67\x65" => $tK27Y->message, "\164\170\111\x64" => $tK27Y->txId ?? '');
            if (!($UWh2h["\163\164\141\x74\x75\x73"] === "\123\x55\103\x43\105\123\123")) {
                goto QkY_V;
            }
            $this->twofautility->log_debug("\101\165\x74\x68\x2e\160\150\x70\40\72\x20\117\x74\160\40\163\145\x6e\x64\x20\163\x75\143\x63\145\163\x66\165\x6c\x6c\171\x3a\x6d\x69\156\x69\157\x72\x61\x6e\147\x65\x20\147\141\164\x65\167\141\x79");
            $this->twofautility->updateColumnInTable("\155\x69\x6e\x69\x6f\x72\x61\156\147\145\137\164\x66\141\137\165\163\145\x72\x73", "\164\162\x61\x6e\163\x61\143\164\151\157\156\x49\x64", $UWh2h["\x74\170\x49\x64"] ?? '', "\x75\163\x65\162\x6e\141\x6d\x65", $ReBne, -1);
            QkY_V:
            TnKQe:
            if ($bfwTr == "\x4f\x4f\123" && $oHHrs) {
                goto fiZqv;
            }
            if ($bfwTr == "\117\x4f\x53") {
                goto Ch9jd;
            }
            goto dLGhW;
            fiZqv:
            $cRCDf = $this->twofautility->Customgateway_GenerateOTP();
            $iid2N = $bRKhR[0]["\x70\x68\157\156\x65"];
            $ZHFok = $bRKhR[0]["\x63\157\x75\156\x74\x72\171\143\157\x64\145"];
            $iid2N = "\53" . $ZHFok . $iid2N;
            $UWh2h = $this->customSMS->send_customgateway_sms($iid2N, $cRCDf);
            goto dLGhW;
            Ch9jd:
            $JOlt4 = new MiniOrangeUser();
            $tK27Y = json_decode($JOlt4->challenge_admin($ReBne, $this->twofautility, $bfwTr, true, -1));
            $UWh2h = array("\163\164\141\x74\165\x73" => $tK27Y->status, "\x6d\145\x73\x73\141\x67\x65" => $tK27Y->message, "\x74\x78\x49\x64" => $tK27Y->txId ?? '');
            if (!($UWh2h["\163\164\x61\x74\x75\163"] === "\123\125\x43\103\x45\123\x53")) {
                goto Su0hO;
            }
            $this->twofautility->log_debug("\101\x75\164\150\x2e\160\150\x70\40\x3a\x20\117\164\160\40\x73\x65\156\144\40\163\165\x63\143\x65\163\x66\x75\x6c\154\x79\72\x6d\x69\x6e\x69\157\x72\141\x6e\147\145\40\x67\x61\164\x65\x77\141\x79");
            $this->twofautility->updateColumnInTable("\x6d\x69\156\x69\157\162\141\x6e\x67\145\137\x74\x66\141\x5f\165\163\145\x72\x73", "\164\x72\x61\x6e\163\141\x63\x74\151\x6f\156\x49\x64", $UWh2h["\164\170\x49\x64"] ?? '', "\165\x73\145\x72\156\141\x6d\145", $ReBne, -1);
            Su0hO:
            dLGhW:
            if (!($bfwTr == "\x4f\x4f\123\x45")) {
                goto g3vQ2;
            }
            $to1Xj = $this->twofautility->Customgateway_GenerateOTP();
            $DOL2_ = $wo9sh;
            $iid2N = $bRKhR[0]["\160\x68\x6f\156\x65"];
            $ZHFok = $bRKhR[0]["\143\x6f\x75\156\x74\x72\171\143\157\x64\x65"];
            $iid2N = "\53" . $ZHFok . $iid2N;
            if ($vFC5a) {
                goto tVJ9v;
            }
            $Vlj6B["\x73\x74\141\x74\165\x73"] = "\x46\101\111\114\x45\x44";
            goto Otg0j;
            tVJ9v:
            $Vlj6B = $this->customEmail->sendCustomgatewayEmail($DOL2_, $to1Xj);
            Otg0j:
            if ($oHHrs) {
                goto DkH8H;
            }
            $dpRDb["\163\x74\x61\164\x75\163"] = "\106\101\111\x4c\x45\104";
            goto CxD1V;
            DkH8H:
            $dpRDb = $this->customSMS->send_customgateway_sms($iid2N, $to1Xj);
            CxD1V:
            if (!($bfwTr == "\x4f\117\123\x45" && $vFC5a == NULL && $oHHrs == NULL)) {
                goto Ve5vh;
            }
            $JOlt4 = new MiniOrangeUser();
            $tK27Y = json_decode($JOlt4->challenge_admin($ReBne, $this->twofautility, $bfwTr, true, -1));
            $UWh2h = array("\163\x74\x61\x74\165\163" => $tK27Y->status, "\155\145\x73\x73\141\147\x65" => $tK27Y->message, "\164\x78\111\x64" => $tK27Y->txId ?? '');
            if (!($UWh2h["\x73\x74\141\164\165\x73"] === "\123\125\x43\x43\x45\123\x53")) {
                goto IH5NQ;
            }
            $this->twofautility->log_debug("\x41\x75\164\150\x2e\160\150\x70\40\72\40\117\x74\160\40\163\145\x6e\x64\x20\x73\165\x63\143\145\x73\146\165\x6c\154\x79\72\155\151\156\151\x6f\x72\141\x6e\147\x65\x20\x67\141\x74\145\167\x61\x79");
            $this->twofautility->updateColumnInTable("\x6d\x69\156\x69\157\x72\141\156\147\145\137\164\x66\x61\137\165\x73\145\162\163", "\164\162\x61\156\163\x61\x63\164\x69\157\156\111\144", $UWh2h["\164\x78\111\x64"] ?? '', "\165\x73\145\x72\156\x61\155\145", $ReBne, -1);
            IH5NQ:
            Ve5vh:
            $Qvmo3 = $this->twofautility->OTP_over_SMSandEMAIL_Message($DOL2_, $iid2N, $Vlj6B["\x73\x74\141\164\165\163"], $dpRDb["\163\x74\x61\x74\165\x73"]);
            if ($Vlj6B["\x73\x74\x61\164\165\163"] == "\x53\x55\x43\x43\x45\x53\x53" || $dpRDb["\x73\164\x61\x74\x75\x73"] == "\123\x55\x43\x43\x45\123\123") {
                goto meZsk;
            }
            $UWh2h = array("\x73\x74\x61\x74\x75\163" => "\106\x41\x49\114\105\x44", "\155\x65\163\x73\141\147\145" => $Qvmo3, "\164\170\111\144" => "\61");
            goto t_HWw;
            meZsk:
            $UWh2h = array("\163\x74\x61\164\165\163" => "\x53\x55\x43\x43\105\123\x53", "\x6d\145\x73\163\x61\x67\x65" => $Qvmo3, "\x74\170\x49\144" => "\x31");
            t_HWw:
            g3vQ2:
            xegbf:
            Alnzt:
            $TpZZ3 = $this->_url->getUrl("\155\157\164\x77\x6f\146\141\57\157\164\160\x2f\141\165\x74\150\151\156\144\145\x78") . "\x3f\46\x73\x74\x65\160\x73\75\x49\x6e\166\157\153\145\101\144\x6d\x69\x6e\x54\x66\141\46\x73\145\154\x65\x63\164\145\144\137\155\x65\x74\x68\157\x64\x3d" . $bfwTr;
            if (!("\x47\157\x6f\x67\x6c\145\101\165\x74\x68\x65\x6e\x74\151\143\141\x74\157\162" != $bfwTr && "\115\x69\143\x72\x6f\163\x6f\146\164\101\x75\164\150\x65\x6e\164\151\x63\141\164\x6f\x72" != $bfwTr && $UWh2h["\163\x74\x61\164\x75\163"] == "\x53\125\103\x43\105\123\x53")) {
                goto LbZN8;
            }
            $this->twofautility->log_debug("\x41\x75\x74\150\56\x70\x68\x70\40\72\40\145\170\145\143\165\x74\145\72\x20\x72\x65\x73\160\x6f\156\x73\145\40\x73\165\x63\x65\x73\163");
            $TpZZ3 = $TpZZ3 . "\x26\163\164\141\164\x75\163\x3d\x53\125\103\103\x45\123\123\x26\163\x74\145\x70\x73\x3d\111\156\x76\157\153\x65\x41\144\155\151\156\x54\146\x61\46\x73\145\x6c\145\143\164\145\144\x5f\x6d\x65\x74\x68\x6f\144\x3d" . $bfwTr . "\x26\x6d\145\163\163\x61\x67\x65\x3d" . $UWh2h["\155\145\163\x73\x61\x67\x65"];
            LbZN8:
            if (!("\107\157\x6f\147\x6c\x65\101\x75\x74\150\145\156\164\151\143\141\164\x6f\162" != $bfwTr && "\x4d\x69\x63\162\157\x73\157\x66\164\x41\x75\164\x68\145\156\x74\151\x63\x61\164\x6f\x72" != $bfwTr && $UWh2h["\x73\164\x61\x74\165\163"] == "\106\x41\111\x4c\x45\x44")) {
                goto EhcpY;
            }
            $this->twofautility->log_debug("\x41\x75\164\150\56\x70\150\160\x20\x3a\40\x4f\164\x70\40\163\145\x6e\x64\40\146\141\x69\154\145\x64");
            $this->twofautility->log_debug("\101\x75\x74\x68\56\160\x68\x70\x20\x3a\x20\145\x78\145\x63\165\164\145\x3a\40\162\145\163\160\157\156\163\x65\40\146\141\151\154\x65\144");
            $TpZZ3 = $TpZZ3 . "\x26\x73\x74\141\x74\165\163\x3d\x46\101\111\x4c\x45\x44\x26\x73\x74\x65\x70\163\75\x49\156\166\x6f\153\x65\x41\x64\155\x69\x6e\x54\146\141\x26\x6d\145\x73\x73\141\x67\x65\x3d" . $UWh2h["\x6d\x65\x73\x73\x61\147\x65"];
            EhcpY:
            $this->_response->setRedirect($TpZZ3);
            MtKhY:
            goto ew3Pp;
            ZiCdV:
            $this->twofautility->log_debug("\x41\165\x74\150\56\160\150\160\x20\x3a\40\x65\x78\145\x63\x75\x74\x65\72\40\142\141\143\153\x64\x6f\x6f\162\40\x6c\x6f\x67\x69\x6e\x20\x65\x78\145\143\165\x74\x65\144\x20\142\x79\x20\x66\157\x6c\x6c\x6f\x77\x69\x6e\x67\40\141\144\x6d\x69\x6e");
            $this->twofautility->log_debug($N5AMO);
            $fZL2D = $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMER_KEY);
            if ($WnVEi["\x62\x61\143\x6b\x64\x6f\x6f\162"] == $fZL2D) {
                goto HAa4m;
            }
            $TpZZ3 = $this->_url->getUrl("\x6d\157\164\167\157\x66\x61\x2f\x6f\164\x70\57\x61\165\164\x68\151\x6e\144\x65\170");
            $TpZZ3 = $TpZZ3 . "\x3f\x26\163\x74\145\x70\163\x3d\102\x61\143\x6b\144\x6f\x6f\x72";
            $this->_response->setRedirect($TpZZ3);
            goto J3Pbq;
            HAa4m:
            return $this->NormalLoginFlow();
            J3Pbq:
            ew3Pp:
            GnGDd:
            if ($this->getAuthStorage()->getUser()) {
                goto pLbxO;
            }
            self::throwException(__("\x59\x6f\x75\40\x64\x69\x64\40\156\157\164\x20\163\x69\x67\156\x20\151\x6e\x20\x63\157\x72\x72\145\x63\x74\x6c\x79\40\x6f\162\x20\x79\x6f\165\x72\40\x61\143\143\157\x75\x6e\164\40\x69\163\x20\x74\x65\x6d\x70\x6f\162\141\x72\x69\154\x79\x20\x64\x69\x73\x61\x62\154\x65\x64\x2e"));
            pLbxO:
        } catch (PluginAuthenticationException $o2Cls) {
            $this->_eventManager->dispatch("\142\x61\x63\153\x65\156\144\137\x61\165\x74\x68\137\x75\163\145\x72\x5f\x6c\157\x67\x69\156\x5f\x66\141\x69\x6c\x65\144", ["\x75\163\145\x72\x5f\156\141\155\x65" => $N5AMO, "\145\x78\143\x65\160\164\151\x6f\x6e" => $o2Cls]);
            throw $o2Cls;
        } catch (LocalizedException $o2Cls) {
            $this->_eventManager->dispatch("\x62\x61\143\153\145\x6e\x64\x5f\x61\x75\164\150\137\165\163\145\162\137\154\157\147\151\x6e\x5f\146\x61\x69\x6c\x65\144", ["\x75\x73\x65\x72\137\x6e\x61\155\145" => $N5AMO, "\145\170\x63\x65\x70\164\151\x6f\156" => $o2Cls]);
            self::throwException(__("\131\157\165\x20\144\151\144\40\x6e\157\164\40\163\x69\x67\x6e\x20\x69\156\40\143\157\x72\162\145\x63\x74\x6c\171\40\x6f\x72\x20\171\157\x75\162\x20\x61\143\143\157\165\156\x74\x20\x69\x73\40\x74\145\x6d\160\x6f\x72\141\x72\151\x6c\171\40\x64\x69\x73\x61\142\x6c\145\144\x2e"));
        }
    }
    public function NormalLoginFlow()
    {
        $this->twofautility->log_debug("\101\165\164\150\x2e\x70\150\x70\40\x3a\40\x65\x78\145\143\165\x74\145\72\x20\x4e\157\x72\155\141\154\x4c\157\x67\x69\156\x46\x6c\x6f\167");
        $this->getAuthStorage()->setUser($this->getCredentialStorage());
        $this->getAuthStorage()->processLogin();
        $this->_eventManager->dispatch("\142\141\x63\153\x65\x6e\144\x5f\x61\x75\x74\150\x5f\165\x73\145\x72\x5f\154\x6f\x67\x69\x6e\x5f\163\165\x63\x63\145\163\x73", ["\x75\x73\145\x72" => $this->getCredentialStorage()]);
    }
    public function check_2fa_disable($bRKhR)
    {
        if (!(isset($bRKhR[0]["\x64\x69\x73\141\142\x6c\145\137\62\x66\x61"]) && $bRKhR[0]["\x64\151\x73\x61\x62\154\145\137\x32\146\x61"] == 1)) {
            goto I322E;
        }
        $this->twofautility->log_debug("\x4c\157\147\x69\156\120\x6f\x73\164\x2e\x70\150\x70\40\72\40\x65\x78\x65\x63\x75\x74\x65\x3a\40\x32\x66\x61\40\151\163\x20\144\x69\163\x61\142\154\x65\x64\40\x66\x6f\x72\40\164\x68\151\x73\40\165\x73\145\x72");
        return true;
        I322E:
        return false;
    }
}