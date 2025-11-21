<?php

namespace MiniOrange\TwoFA\Controller\Account;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\Account\Redirect as AccountRedirect;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\AuthenticationException;
use Magento\Framework\Exception\EmailNotConfirmedException;
use MiniOrange\TwoFA\Helper\CustomEmail;
use MiniOrange\TwoFA\Helper\CustomSMS;
use MiniOrange\TwoFA\Helper\MiniOrangeUser;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
class LoginPost extends \Magento\Customer\Controller\Account\LoginPost
{
    protected $customEmail;
    protected $resultFactory;
    protected $response;
    protected $customSMS;
    protected $customerUrl;
    protected $TwoFAUtility;
    protected $storeManager;
    protected $session;
    protected $customerAccountManagement;
    protected $formKeyValidator;
    protected $accountRedirect;
    protected $_response;
    private $cookieManager;
    private $cookieMetadataFactory;
    private $url;
    private $moduleManager;
    public function __construct(Context $Sra9h, Session $hcAr6, AccountManagementInterface $x4wQg, CustomerUrl $J4hRZ, Validator $OCp2i, AccountRedirect $AiruY, CustomEmail $f93SH, CustomSMS $eyHvE, TwoFAUtility $PKWS1, ResponseInterface $IMYW4, \Magento\Framework\Controller\ResultFactory $LG2ZH, \Magento\Framework\Stdlib\CookieManagerInterface $IlZPk, \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $GV6U2, \Magento\Framework\Module\Manager $ghbQy, \Magento\Framework\UrlInterface $AxS1y, \Magento\Store\Model\StoreManagerInterface $OZPbB)
    {
        $this->session = $hcAr6;
        $this->customerAccountManagement = $x4wQg;
        $this->customerUrl = $J4hRZ;
        $this->formKeyValidator = $OCp2i;
        $this->accountRedirect = $AiruY;
        $this->customEmail = $f93SH;
        $this->customSMS = $eyHvE;
        $this->TwoFAUtility = $PKWS1;
        $this->cookieManager = $IlZPk;
        $this->cookieMetadataFactory = $GV6U2;
        $this->moduleManager = $ghbQy;
        $this->url = $AxS1y;
        $this->_response = $IMYW4;
        $this->resultFactory = $LG2ZH;
        $this->storeManager = $OZPbB;
        parent::__construct($Sra9h, $hcAr6, $x4wQg, $J4hRZ, $OCp2i, $AiruY);
    }
    public function execute()
    {
        $this->TwoFAUtility->log_debug("\x2d\x2d\55\55\x2d\55\55\x2d\x2d\55\55\x2d\x2d\x2d\55\55\x2d\55\x2d\x2d\x2d\55\x2d\55\55\x2d\x2d\55\x2d\55\x2d\55\x2d\55\x2d\55\55\55\x2d\x2d\x2d\55\55\x2d\x2d\x2d\x2d\55\55\x2d\105\170\x65\x63\165\x74\145\40\x4c\157\147\x69\x6e\x50\157\x73\164\72\x2d\55\x2d\55\x2d\55\x2d\55\x2d\55\x2d\55\x2d\55\55\55\55\55\x2d\55\55\x2d\55\55\55\55\55\x2d\x2d\55\55\x2d\x2d\55\x2d\55\55\x2d\55\55\55\x2d\55\x2d\55\55\x2d\x2d");
        if (!($this->session->isLoggedIn() || !$this->formKeyValidator->validate($this->getRequest()))) {
            goto eA8lb;
        }
        $wXpbA = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $wXpbA->setPath("\x63\x75\163\x74\157\x6d\145\162\x2f\x61\143\x63\157\165\156\164");
        $HHxhX = $this->url->getCurrentUrl();
        $this->TwoFAUtility->log_debug("\x73\164\x65\160\163\40\x31\40");
        return $wXpbA;
        eA8lb:
        if (!$this->getRequest()->isPost()) {
            goto CZgh7;
        }
        $N3mJ4 = $this->getRequest()->getPost("\x6c\157\147\x69\156");
        $wXpbA = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $fh4cC = $this->TwoFAUtility->getWebsiteOrStoreBasedOnTrialStatus();
        $this->TwoFAUtility->log_debug("\163\x74\145\160\163\40\62\40");
        if (!empty($N3mJ4["\165\163\145\x72\156\x61\155\x65"]) && !empty($N3mJ4["\160\x61\x73\163\167\x6f\162\144"])) {
            goto CHl_M;
        }
        $this->TwoFAUtility->log_debug("\105\x78\145\x63\x75\x74\145\x20\114\157\x67\151\156\120\157\163\164\x3a\x20\125\x73\145\162\156\141\x6d\145\40\x6f\162\40\160\x61\x73\163\x77\157\162\x64\x20\x6e\165\154\154");
        $this->messageManager->addError(__("\x41\40\x6c\157\x67\x69\x6e\x20\x61\x6e\x64\40\x61\x20\160\x61\163\163\167\x6f\162\x64\x20\x61\162\145\x20\162\x65\x71\165\x69\x72\145\144\x2e"));
        $wXpbA->setPath("\143\x75\x73\x74\157\155\145\x72\x2f\x61\x63\x63\x6f\x75\156\164\57\x6c\157\147\x69\x6e");
        $HHxhX = $this->url->getCurrentUrl();
        $this->TwoFAUtility->log_debug("\x43\165\x72\162\145\x6e\x74\x20\125\x52\x4c\40\75\76\40\x63\x75\x73\164\x6f\155\145\162\57\x61\x63\x63\x6f\165\156\x74\x2f\x6c\157\147\151\x6e\x20");
        return $wXpbA;
        goto KtbVQ;
        CHl_M:
        try {
            $HbQqT = $this->customerAccountManagement->authenticate($N3mJ4["\x75\163\145\162\x6e\x61\x6d\145"], $N3mJ4["\x70\x61\163\163\x77\x6f\162\x64"]);
            $this->TwoFAUtility->log_debug("\x73\x74\x65\x70\x73\40\x33");
            $stmi7 = $this->TwoFAUtility->getCustomerFromAttributes($N3mJ4["\x75\163\x65\162\156\x61\155\145"]);
            $this->TwoFAUtility->log_debug("\x4c\x6f\x67\x69\x6e\x50\157\163\164\x2e\160\150\160\40\x3a\x20\x65\x78\x65\143\165\x74\x65\x3a\x20\x67\x65\164\103\165\163\164\x6f\155\145\x72\x46\162\x6f\155\101\164\164\x72\151\142\x75\164\145\163\40\165\x73\x65\x72\x5f\x64\x65\164\141\151\x6c\163\40\147\x72\x6f\x75\x70\40\151\x64", $stmi7["\x67\162\x6f\x75\160\137\151\x64"]);
            $this->TwoFAUtility->log_debug("\x4c\157\x67\151\156\x50\157\163\x74\56\160\150\x70\x20\72\40\x65\170\145\x63\x75\x74\x65\72\x20\147\145\164\103\x75\x73\x74\x6f\155\x65\162\x46\162\x6f\x6d\101\164\x74\162\151\x62\x75\164\145\x73\40\x75\x73\145\x72\137\144\145\x74\x61\x69\x6c\x73\x20\145\155\141\151\x6c", $stmi7["\x65\x6d\x61\151\x6c"]);
            if (!$this->TwoFAUtility->checkBlacklistedIP()) {
                goto yBX_N;
            }
            return $this->blockLogin();
            yBX_N:
            $niz9v = $this->TwoFAUtility->getGroupNameById($stmi7["\147\162\x6f\165\160\x5f\151\144"]);
            $this->TwoFAUtility->log_debug("\114\x6f\147\x69\x6e\120\x6f\163\x74\x2e\x70\150\x70\x20\72\x20\x65\x78\145\x63\x75\x74\145\72\40\x67\x65\x74\107\162\x6f\165\160\116\141\155\145\102\171\111\144\40\x63\x75\x73\x74\157\155\x65\162\137\x72\x6f\x6c\145\x5f\x6e\x61\x6d\145", $niz9v);
            $DSU8K = $this->TwoFAUtility->getGlobalConfig(TwoFAConstants::CURRENT_CUSTOMER_RULE);
            $this->TwoFAUtility->log_debug("\x4c\157\x67\x69\156\x50\x6f\x73\x74\x2e\x70\150\160\40\x3a\x20\145\170\x65\143\165\x74\x65\x3a\x20\147\145\164\x47\x6c\x6f\x62\141\154\x43\x6f\x6e\146\x69\x67\40\143\165\163\x74\x6f\x6d\x65\162\x5f\x72\165\x6c\x65\x73", $DSU8K);
            $jI0Ed = $this->TwoFAUtility->getCustomer2FAMethodsFromRules($niz9v, $fh4cC);
            $PUijd = $jI0Ed["\155\x65\164\150\157\x64\163"];
            $eMZ6P = $jI0Ed["\x63\x6f\x75\x6e\x74"] > 0;
            $IWGEK = false;
            if (!$DSU8K) {
                goto v5hj7;
            }
            $MmGHd = json_decode($DSU8K, true);
            if (!is_array($MmGHd)) {
                goto Cb3NF;
            }
            $dRq_1 = null;
            $VJNnk = null;
            foreach ($MmGHd as $i9P2A) {
                if (!(isset($i9P2A["\x73\151\164\x65"]) && isset($i9P2A["\147\162\x6f\x75\x70"]))) {
                    goto fV9mm;
                }
                $ChIv1 = $i9P2A["\x73\151\x74\x65"] === "\x41\x6c\x6c\x20\123\x69\x74\145\x73" || $i9P2A["\163\151\x74\145"] === $this->TwoFAUtility->getWebsiteNameById($fh4cC);
                $V_WnT = $i9P2A["\147\162\157\165\x70"] === "\101\x6c\x6c\40\107\162\157\165\160\x73" || $i9P2A["\x67\162\x6f\x75\x70"] === $niz9v;
                if (!($ChIv1 && $V_WnT)) {
                    goto NyU3E;
                }
                if ($i9P2A["\x73\x69\164\145"] === $this->TwoFAUtility->getWebsiteNameById($fh4cC)) {
                    goto kbn3w;
                }
                if ($i9P2A["\x73\151\164\x65"] === "\101\x6c\x6c\x20\x53\x69\x74\145\163") {
                    goto pBYh2;
                }
                goto BXHin;
                kbn3w:
                $dRq_1 = $i9P2A;
                goto BXHin;
                pBYh2:
                $VJNnk = $i9P2A;
                BXHin:
                NyU3E:
                fV9mm:
                DGvSf:
            }
            UwEB5:
            $ibv4B = $dRq_1 ?: $VJNnk;
            if (!$ibv4B) {
                goto QYAzd;
            }
            $IWGEK = true;
            $FaB8M = $dRq_1 ? "\167\145\x62\163\151\x74\145\x2d\x73\160\145\143\x69\146\x69\143" : "\147\154\x6f\x62\x61\x6c";
            QYAzd:
            Cb3NF:
            v5hj7:
            if (!(!$IWGEK && $eMZ6P)) {
                goto KLR4e;
            }
            $IWGEK = true;
            KLR4e:
            $UBoZG = $this->TwoFAUtility->check2fa_backend_plan();
            $this->TwoFAUtility->log_debug("\114\157\147\x69\x6e\120\157\x73\164\x2e\160\x68\x70\40\72\x20\145\170\x65\143\165\164\x65\x3a\40\143\x68\145\x63\153\x32\146\x61\x5f\142\141\x63\x6b\145\x6e\144\137\x70\154\x61\156", $UBoZG);
            if (!$this->TwoFAUtility->isTrialExpired()) {
                goto RYjfh;
            }
            return $this->defaultLoginFlow_withErrorMessage($HbQqT);
            RYjfh:
            if ($IWGEK && $eMZ6P && $UBoZG && !$this->TwoFAUtility->checkIPs("\143\165\x73\x74\x6f\155\145\162")) {
                goto XvbUP;
            }
            $this->TwoFAUtility->log_debug("\x45\x78\145\x63\x75\x74\145\x20\114\x6f\147\151\156\x50\157\163\164\x3a\x20\111\x6e\166\x6f\x6b\145\40\111\x6e\x6c\x69\156\145\40\x6f\x66\146");
            $this->session->setCustomerDataAsLoggedIn($HbQqT);
            $this->session->regenerateId();
            goto aBnkb;
            XvbUP:
            $this->TwoFAUtility->log_debug("\163\164\x65\x70\x73\x20\64\40\143\x6f\155\151\x6e\147\40\x69\156\x20\x69\x6e\x76\157\153\x65\151\156\154\151\x6e\x65\40");
            $this->TwoFAUtility->log_debug("\x45\x78\x65\x63\x75\x74\x65\40\114\x6f\x67\x69\x6e\x50\x6f\x73\x74\72\40\x49\x6e\x6c\x69\156\x65\40\111\156\166\157\x6b\145\144\40\x61\156\x64\x20\x66\157\x75\156\144\40\x61\143\x74\151\166\145\40\x6d\x65\x74\x68\x6f\x64");
            $A5AEW = $N3mJ4["\165\x73\x65\x72\x6e\141\155\145"];
            $this->TwoFAUtility->setSessionValue("\155\157\165\163\x65\162\x6e\x61\x6d\x65", $N3mJ4["\165\163\145\x72\x6e\141\x6d\x65"]);
            $this->setCookie("\x6d\x6f\165\x73\x65\x72\x6e\141\x6d\145", $A5AEW);
            $d4I2H = $this->TwoFAUtility->getCustomerMoTfaUserDetails("\155\151\x6e\151\x6f\162\141\x6e\147\145\x5f\164\x66\x61\137\165\x73\145\x72\x73", $A5AEW);
            if (!$this->handleRememberDeviceCheck($N3mJ4["\165\x73\145\x72\x6e\141\155\145"], $fh4cC, $d4I2H)) {
                goto YKMw3;
            }
            $this->TwoFAUtility->log_debug("\x4c\157\x67\151\156\120\x6f\x73\164\56\x70\150\160\40\55\76\x20\144\x65\x66\141\165\x6c\x74\40\154\157\147\151\x6e\40\x66\x6c\x6f\167\x20\151\156\x20\162\145\155\x65\x6d\x62\x65\162\40\x6d\171\40\x64\x65\166\151\143\145");
            return $this->defaultLoginFlow($HbQqT);
            YKMw3:
            if (!$this->handleSkipTwoFA($HbQqT, $d4I2H, $fh4cC)) {
                goto uvRt3;
            }
            return $this->defaultLoginFlow($HbQqT);
            uvRt3:
            $lg2nz = '';
            $jI0Ed = $this->TwoFAUtility->getCustomer2FAMethodsFromRules($niz9v, $fh4cC);
            $Ng22F = $jI0Ed["\x63\157\165\156\x74"];
            $this->TwoFAUtility->log_debug("\x45\x78\x65\x63\x75\x74\145\x20\x4c\x6f\147\x69\x6e\120\157\163\164\72\40\x43\150\145\143\153\151\156\x67\x20\x75\163\145\x72\40\x66\x6c\157\167\x20\55\x20\155\145\164\150\157\144\x73\x20\143\x6f\165\x6e\164\x3a\40" . $Ng22F);
            $this->TwoFAUtility->log_debug("\x45\170\x65\x63\x75\164\145\40\x4c\x6f\x67\x69\156\120\x6f\x73\164\72\40\x55\163\145\x72\x20\x72\x6f\167\x20\145\170\x69\163\x74\x73\x3a\40" . (is_array($d4I2H) && sizeof($d4I2H) > 0 ? "\x79\x65\x73" : "\156\x6f"));
            if (!(is_array($d4I2H) && sizeof($d4I2H) > 0)) {
                goto mYh83;
            }
            $this->TwoFAUtility->log_debug("\x45\x78\145\x63\165\x74\145\40\114\157\x67\x69\x6e\120\157\x73\164\72\x20\x55\x73\145\162\40\163\153\x69\160\137\x74\x77\157\146\141\x20\x76\141\x6c\165\x65\x3a\x20" . ($d4I2H[0]["\x73\153\x69\160\137\164\x77\x6f\x66\x61"] ?? "\x6e\x75\154\x6c"));
            mYh83:
            if (!(is_array($d4I2H) && sizeof($d4I2H) > 0 && $this->check_2fa_disable($d4I2H))) {
                goto wJl5g;
            }
            $this->TwoFAUtility->log_debug("\105\170\x65\x63\x75\x74\145\x20\x4c\157\x67\x69\x6e\x50\x6f\163\164\72\x20\62\x46\x41\40\151\x73\40\x64\151\x73\x61\142\154\145\x64\x20\146\157\162\40\164\x68\x69\x73\40\x75\x73\x65\x72\x2c\x20\x70\x72\157\x63\x65\x65\144\151\156\147\40\167\x69\164\x68\x20\144\145\x66\141\165\154\164\x20\154\157\x67\151\156");
            return $this->defaultLoginFlow($HbQqT);
            wJl5g:
            if (is_array($d4I2H) && sizeof($d4I2H) > 0 && (isset($d4I2H[0]["\x73\153\151\160\x5f\164\167\157\146\141"]) && ($d4I2H[0]["\x73\153\151\x70\137\x74\167\157\x66\x61"] == NULL || $d4I2H[0]["\163\x6b\x69\x70\x5f\164\x77\157\146\x61"] == ''))) {
                goto hY3Zz;
            }
            if ($Ng22F > 1) {
                goto Kvrt2;
            }
            $this->TwoFAUtility->log_debug("\105\170\145\x63\x75\x74\x65\40\x4c\157\147\x69\156\120\x6f\163\164\72\x20\125\x73\145\x72\x20\x69\163\40\156\x65\x77\x20\x6f\162\x20\x68\x61\x73\40\156\x6f\40\141\143\x74\x69\x76\x65\x20\155\145\x74\150\x6f\144\x2c\x20\143\x61\x6c\154\x69\156\147\40\150\x61\156\x64\x6c\145\116\x65\x77\x32\x46\x41\x55\x73\145\162");
            return $this->handleNew2FAUser($A5AEW, $niz9v, $fh4cC, $wXpbA);
            goto SB47h;
            hY3Zz:
            $this->TwoFAUtility->log_debug("\105\170\x65\143\165\164\145\40\114\x6f\x67\151\156\x50\x6f\163\164\x3a\x20\x55\x73\145\x72\x20\151\163\40\x65\170\151\x73\164\x69\156\147\40\62\106\101\40\x75\x73\x65\162\54\40\x63\141\x6c\x6c\x69\x6e\147\x20\150\141\156\144\154\x65\105\170\151\x73\x74\x69\x6e\x67\62\106\101\x55\x73\145\162");
            return $this->handleExisting2FAUser($HbQqT, $A5AEW, $d4I2H, $fh4cC, $wXpbA);
            goto SB47h;
            Kvrt2:
            $this->TwoFAUtility->log_debug("\x45\x78\x65\x63\165\164\x65\x20\x4c\x6f\x67\151\x6e\120\157\163\164\72\x20\115\165\154\x74\x69\160\154\x65\40\155\x65\x74\150\157\x64\x73\40\x61\166\x61\151\154\x61\142\154\x65\54\x20\163\150\x6f\x77\x69\156\x67\x20\155\x65\164\x68\x6f\x64\40\163\x65\x6c\145\x63\164\x69\x6f\x6e");
            return $this->handleNew2FAUser($A5AEW, $niz9v, $fh4cC, $wXpbA);
            SB47h:
            return $wXpbA;
            aBnkb:
        } catch (EmailNotConfirmedException $Yz7yp) {
            $m0CRX = $this->customerUrl->getEmailConfirmationUrl($N3mJ4["\x75\163\x65\162\x6e\141\x6d\x65"]);
            $LtSM0 = __("\x54\150\151\163\40\x61\x63\143\157\165\156\x74\x20\x69\x73\40\156\157\x74\x20\x63\x6f\x6e\x66\x69\162\155\x65\x64\x2e" . "\x20\x3c\x61\40\150\x72\x65\146\x3d\x22\x25\x31\x22\76\x43\154\x69\143\x6b\40\150\x65\x72\145\74\57\141\76\40\164\157\x20\x72\145\x73\x65\x6e\144\40\143\157\x6e\146\x69\x72\155\x61\x74\151\x6f\x6e\x20\x65\155\x61\x69\154\x2e", $m0CRX);
            $this->messageManager->addError($LtSM0);
            $this->session->setUsername($N3mJ4["\x75\163\x65\x72\x6e\141\155\x65"]);
            $wXpbA->setPath("\143\x75\163\x74\157\x6d\x65\x72\57\x61\143\143\157\165\x6e\164\57\x6c\x6f\147\x69\x6e");
            $HHxhX = $this->url->getCurrentUrl();
            $this->TwoFAUtility->log_debug("\x43\x75\x72\x72\x65\x6e\x74\x20\125\122\114\40\x3d\x3e\40\x63\x75\163\164\157\x6d\x65\x72\x2f\x61\143\143\157\x75\x6e\164\57\154\157\x67\151\x6e\40");
            return $wXpbA;
        } catch (AuthenticationException $Yz7yp) {
            $LtSM0 = __("\111\x6e\166\x61\154\151\x64\40\x6c\157\147\x69\156\x20\157\x72\40\x70\x61\x73\x73\x77\157\162\x64\56");
            $this->messageManager->addError($LtSM0);
            $this->session->setUsername($N3mJ4["\x75\163\x65\162\x6e\141\x6d\145"]);
            $wXpbA->setPath("\x63\x75\x73\164\x6f\155\145\162\x2f\x61\143\x63\x6f\x75\156\x74\57\x6c\x6f\x67\151\x6e");
            $HHxhX = $this->url->getCurrentUrl();
            $this->TwoFAUtility->log_debug("\103\x75\x72\162\x65\156\x74\40\125\122\114\x20\x3d\x3e\x20\x63\x75\163\x74\157\x6d\x65\x72\57\141\143\143\157\x75\156\164\57\x6c\x6f\147\x69\x6e\x20");
            return $wXpbA;
        } catch (\Exception $Yz7yp) {
            $this->messageManager->addError(__("\x49\156\x76\141\x6c\x69\144\40\x6c\157\147\151\156\40\157\162\x20\x70\141\x73\x73\x77\x6f\x72\144\56"));
            $wXpbA->setPath("\x63\x75\163\164\x6f\155\145\x72\x2f\141\143\143\157\165\x6e\164\57\154\x6f\x67\x69\x6e");
            $HHxhX = $this->url->getCurrentUrl();
            $this->TwoFAUtility->log_debug("\103\x75\x72\162\145\156\x74\40\125\x52\114\40\75\76\40\143\x75\x73\x74\157\155\145\x72\57\x61\x63\x63\157\x75\x6e\x74\57\x6c\x6f\x67\151\x6e\40");
            return $wXpbA;
        }
        KtbVQ:
        CZgh7:
        $wXpbA = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $wXpbA->setPath("\143\165\163\164\157\x6d\145\162\57\x61\x63\143\x6f\x75\156\164");
        $this->TwoFAUtility->log_debug("\x43\x75\162\x72\x65\156\x74\x20\x55\122\114\x20\x3d\x3e\x20\143\165\x73\164\157\155\145\162\57\x61\x63\143\x6f\x75\156\x74");
        return $wXpbA;
    }
    public function blockLogin() : mixed
    {
        $LtSM0 = __("\x59\x6f\165\162\x20\111\120\40\x69\163\x20\142\x6c\141\143\x6b\x6c\x69\163\164\145\144\56\x20\120\x6c\x65\x61\163\x65\x20\103\x6f\156\164\141\x63\164\40\171\x6f\x75\x72\x20\101\144\x6d\151\x6e\151\163\164\x72\x61\x74\x6f\162\40\164\157\40\x77\x68\x69\164\145\154\x69\163\x74\40\111\120");
        $this->messageManager->addError($LtSM0);
        $wXpbA = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $wXpbA->setPath("\x63\165\x73\164\x6f\x6d\145\162\x2f\141\143\143\x6f\165\156\x74\x2f\154\157\147\x69\156");
        $HHxhX = $this->url->getCurrentUrl();
        $this->TwoFAUtility->log_debug("\103\x75\162\162\145\156\x74\40\125\x52\x4c\40\x3d\76\40\x63\x75\x73\x74\x6f\155\x65\x72\57\141\143\x63\157\x75\156\164\x2f\x6c\157\x67\x69\x6e");
        return $wXpbA;
    }
    public function defaultLoginFlow_withErrorMessage($HbQqT)
    {
        $this->TwoFAUtility->log_debug("\x4c\157\x67\151\x6e\x50\x6f\163\164\56\x70\150\160\72\40\x65\x78\145\x63\x75\164\145\x20\72\x20\x59\x6f\165\x72\40\144\x65\155\157\x20\141\143\143\157\165\156\x74\x20\150\141\x73\40\145\170\160\x69\x72\x65\x64\56");
        $this->messageManager->addErrorMessage("\131\157\165\x72\40\x44\145\x6d\x6f\40\x61\x63\143\157\x75\156\x74\40\150\141\163\x20\145\x78\160\151\x72\145\144\56\40\x50\x6c\145\141\163\x65\40\x63\157\x6e\x74\x61\143\x74\x20\x6d\x61\147\145\x6e\164\x6f\163\165\160\x70\157\162\164\100\x78\x65\143\165\162\x69\x66\x79\56\x63\x6f\155");
        $this->session->setCustomerDataAsLoggedIn($HbQqT);
        $wXpbA = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $this->session->regenerateId();
        $wXpbA->setPath("\143\165\163\x74\157\155\145\162\x2f\x61\143\x63\x6f\165\156\x74");
        $this->TwoFAUtility->log_debug("\x4c\x6f\147\151\x6e\40\163\165\x63\x63\145\x73\x73\x66\165\x6c\40\167\151\x74\x68\157\x75\164\40\x32\106\x41\x2e");
        return $wXpbA;
    }
    private function setCookie($dPfUT, $m0CRX)
    {
        $f8nph = $this->cookieMetadataFactory->createPublicCookieMetadata()->setDurationOneYear()->setPath("\57")->setHttpOnly(false);
        $this->cookieManager->setPublicCookie($dPfUT, $m0CRX, $f8nph);
    }
    public function handleRememberDeviceCheck($N_cRc, $pgSCp, $d4I2H)
    {
        $MuBLs = $this->TwoFAUtility->getStoreConfig(TwoFAConstants::CUSTOMER_REMEMBER_DEVICE);
        if (!($MuBLs && isset($d4I2H) && !empty($d4I2H) && isset($d4I2H[0]["\144\x65\x76\x69\x63\x65\x5f\151\156\x66\x6f"]) && $d4I2H[0]["\144\145\166\151\143\145\137\151\x6e\146\x6f"] != '')) {
            goto lx946;
        }
        $this->TwoFAUtility->log_debug("\x4c\x6f\x67\151\156\x50\157\163\x74\x2e\160\150\160\40\72\x20\111\156\163\x69\x64\145\40\144\145\166\x69\143\x65\55\x62\x61\163\x65\144\x20\x72\145\x73\164\162\x69\143\164\x69\157\x6e\x20\x63\150\145\x63\153\56");
        $b8hob = json_decode($d4I2H[0]["\x64\145\x76\x69\143\145\x5f\151\156\146\157"], true);
        $Pxeh1 = json_decode($this->TwoFAUtility->getCurrentDeviceInfo(), true);
        if ($Pxeh1) {
            goto b_x2Y;
        }
        $this->TwoFAUtility->log_debug("\114\157\x67\151\156\120\157\163\x74\x2e\x70\150\x70\40\x3a\40\x4e\157\40\x63\x75\162\162\145\156\x74\40\x64\x65\166\151\x63\145\40\x69\x6e\x66\x6f\x72\x6d\x61\164\151\x6f\156\x20\146\x6f\165\x6e\x64\x2e");
        return false;
        b_x2Y:
        $duA1U = (int) $this->TwoFAUtility->getStoreConfig(TwoFAConstants::CUSTOMER_REMEMBER_DEVICE_LIMIT);
        $xA1z1 = date("\x59\x2d\x6d\55\x64");
        $this->TwoFAUtility->log_debug("\114\x6f\147\151\x6e\x50\x6f\163\164\x2e\160\150\x70\40\x3a\40\x44\145\x76\x69\143\145\40\144\x61\x79\40\x6c\151\x6d\x69\164\72\40" . $duA1U);
        foreach ($b8hob as $x2H1K) {
            $CxQLo = true;
            $nywYS = ["\x46\x69\x6e\147\x65\162\x70\x72\151\x6e\x74"];
            foreach ($nywYS as $MzwZU) {
                if (!(!isset($x2H1K[$MzwZU]) || !isset($Pxeh1[$MzwZU]) || $x2H1K[$MzwZU] !== $Pxeh1[$MzwZU])) {
                    goto Qeun0;
                }
                $CxQLo = false;
                goto PZqbf;
                Qeun0:
                kpVV2:
            }
            PZqbf:
            if (!$CxQLo) {
                goto pXNJF;
            }
            $qHmZw = "\x64\145\x76\x69\143\x65\x5f\151\x6e\x66\x6f\x5f" . hash("\163\x68\x61\62\x35\x36", $N_cRc);
            $ucCdG = $_COOKIE[$qHmZw] ?? null;
            if (!($ucCdG !== $x2H1K["\122\141\156\x64\x6f\x6d\137\x73\x74\x72\x69\x6e\147"])) {
                goto niMRW;
            }
            $this->TwoFAUtility->log_debug("\114\157\147\x69\x6e\x50\x6f\x73\x74\56\160\x68\x70\40\x3a\40\103\157\157\x6b\x69\x65\x73\40\144\x6f\40\x6e\x6f\x74\40\155\x61\164\x63\x68\x20\167\151\x74\x68\x20\146\151\156\147\145\x72\x70\162\151\x6e\x74\x2e");
            $CxQLo = false;
            niMRW:
            pXNJF:
            if (!$CxQLo) {
                goto kIGjJ;
            }
            $this->TwoFAUtility->log_debug("\x4c\157\147\151\156\120\x6f\x73\x74\56\160\150\x70\40\x3a\40\x44\x65\x76\151\x63\x65\40\x6d\141\x74\143\x68\x65\163\72\40" . $CxQLo);
            $fwYXs = $x2H1K["\143\x6f\x6e\146\x69\x67\x75\x72\x65\x64\137\x64\141\x74\x65"];
            $zz9br = (strtotime($xA1z1) - strtotime($fwYXs)) / (60 * 60 * 24);
            if (!($zz9br < $duA1U)) {
                goto M2Uxn;
            }
            $this->TwoFAUtility->log_debug("\x4c\x6f\x67\x69\x6e\x50\x6f\163\x74\x2e\x70\x68\160\40\x3a\40\104\x65\x76\x69\143\x65\40\x6d\x61\x74\143\150\x65\163\x20\141\x6e\144\x20\x72\145\155\141\x69\x6e\x69\156\x67\40\x64\x61\171\x73\40\x3c\x20\144\x65\x76\x69\143\x65\40\x64\141\x79\40\154\151\x6d\x69\x74\56\40\122\x65\x6d\141\151\156\151\156\147\x20\104\141\171\163\72\x20" . $zz9br);
            $this->TwoFAUtility->log_debug("\114\x6f\x67\x69\x6e\x50\157\x73\164\56\160\x68\160\x20\72\x20\x4c\x6f\x67\x67\x69\x6e\147\x20\151\x6e\x20\167\151\x74\x68\157\165\164\40\62\106\x41\x20\x64\165\145\x20\x74\x6f\x20\155\x61\164\143\150\151\x6e\x67\40\144\145\x76\x69\x63\x65\56");
            return true;
            M2Uxn:
            $this->TwoFAUtility->log_debug("\114\157\147\x69\156\x50\157\163\x74\x2e\160\x68\160\40\72\40\115\x61\x74\143\x68\x69\x6e\147\x20\144\x65\x76\151\143\x65\x20\146\x6f\x75\156\144\40\x62\165\164\x20\157\165\x74\x73\151\x64\x65\40\x74\x68\145\40\141\x6c\x6c\x6f\167\x65\144\x20\x64\x61\x79\x20\154\x69\155\151\x74\56");
            goto egHkS;
            kIGjJ:
            a_sbN:
        }
        egHkS:
        lx946:
        $this->TwoFAUtility->log_debug("\114\157\x67\151\x6e\120\157\163\x74\56\x70\x68\x70\x20\72\x20\x4e\157\x20\x6d\x61\164\143\x68\151\156\147\40\x64\x65\x76\x69\143\x65\x20\x66\x6f\x75\156\x64\x20\x77\x69\164\x68\x69\156\40\141\154\x6c\157\x77\x65\x64\40\144\141\x79\40\154\151\155\151\x74\x20\x66\x6f\x72\x20\x75\163\145\162\x3a\40" . $N_cRc);
        return false;
    }
    public function defaultLoginFlow($HbQqT)
    {
        $this->session->setCustomerDataAsLoggedIn($HbQqT);
        $wXpbA = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $wXpbA->setPath("\x63\165\163\x74\x6f\155\145\x72\x2f\x61\143\x63\x6f\x75\x6e\164");
        $this->TwoFAUtility->log_debug("\x4c\157\x67\151\156\40\163\165\143\x63\145\x73\x73\146\165\154\x20\x77\151\164\x68\x6f\165\x74\40\62\x46\101\x2e");
        return $wXpbA;
    }
    public function handleSkipTwoFA($HbQqT, $d4I2H, $fh4cC)
    {
        $this->TwoFAUtility->log_debug("\114\157\x67\x69\156\120\x6f\x73\164\x20\75\76\x68\x61\156\144\x6c\x65\x53\153\151\x70\x54\x77\157\106\101\x3a\x20\x45\156\x74\145\162\151\156\147\40\x66\165\x6e\143\164\x69\157\x6e\56");
        $kmRjo = (int) $this->TwoFAUtility->getStoreConfig(TwoFAConstants::SKIP_TWOFA);
        if (!($kmRjo != 1)) {
            goto swA_7;
        }
        $this->TwoFAUtility->log_debug("\114\157\147\x69\x6e\120\157\x73\x74\x20\75\76\x68\x61\156\x64\154\145\x53\x6b\151\160\x54\167\x6f\106\x41\x3a\x20\123\153\x69\160\x20\62\x46\x41\x20\151\x73\40\156\x6f\164\x20\x65\156\x61\x62\154\145\144\x2e");
        return false;
        swA_7:
        $rm7WT = $this->TwoFAUtility->getStoreConfig(TwoFAConstants::SKIP_TWOFA_DAYS);
        $this->TwoFAUtility->log_debug("\114\157\147\x69\156\x50\x6f\x73\x74\40\75\x3e\x68\x61\156\x64\x6c\x65\x53\153\151\x70\124\x77\x6f\106\101\x3a\x20\123\153\x69\160\x20\62\x46\101\40\x64\x61\x79\163\x20\x63\157\156\146\x69\147\165\162\x61\x74\x69\x6f\156\x3a\40" . $rm7WT);
        if (!(!empty($d4I2H) && isset($d4I2H[0]["\x73\153\151\x70\x5f\164\167\157\146\x61\137\x70\162\145\155\x61\156\x65\156\x74"]) && $d4I2H[0]["\x73\x6b\151\x70\137\164\x77\157\146\x61\137\160\x72\145\x6d\x61\156\x65\x6e\x74"] == true && $rm7WT == "\160\x65\x72\x6d\141\x6e\145\156\164")) {
            goto UqN4w;
        }
        $this->TwoFAUtility->log_debug("\114\157\x67\x69\156\120\x6f\163\164\x20\x3d\x3e\150\141\x6e\x64\154\145\x53\153\x69\x70\124\x77\x6f\106\101\72\x20\125\163\145\162\x20\150\141\x73\40\x70\x65\162\155\141\156\x65\156\x74\154\171\x20\163\153\x69\160\160\x65\144\x20\62\x46\101\56");
        return $this->defaultLoginFlow($HbQqT);
        UqN4w:
        if (!(!empty($d4I2H) && isset($d4I2H[0]["\x73\x6b\151\160\x5f\164\167\157\x66\x61\x5f\143\157\x6e\146\151\147\x75\162\x65\144\x5f\144\141\164\x65"]) && $d4I2H[0]["\x73\x6b\x69\x70\x5f\x74\x77\157\x66\x61\x5f\x63\157\156\146\x69\x67\165\x72\145\144\137\x64\x61\x74\x65"] != NULL)) {
            goto kgghP;
        }
        $this->TwoFAUtility->log_debug("\x4c\157\x67\x69\156\120\x6f\x73\164\40\75\x3e\150\141\x6e\144\x6c\145\x53\153\151\x70\x54\167\157\x46\x41\x3a\40\124\145\155\160\157\x72\x61\162\x79\40\163\153\151\160\40\62\106\101\x20\144\x61\164\x61\x20\145\x78\x69\x73\164\163\x2e");
        $VKDbQ = json_decode($d4I2H[0]["\x73\x6b\x69\160\x5f\164\167\x6f\x66\x61\x5f\x63\157\x6e\146\151\x67\x75\x72\145\x64\137\x64\x61\164\x65"], true);
        if (!isset($VKDbQ["\x63\x6f\x6e\x66\x69\147\x75\x72\x65\x64\137\144\x61\164\x65"])) {
            goto WsqmG;
        }
        $fwYXs = $VKDbQ["\143\157\156\x66\151\147\165\162\145\144\x5f\144\141\164\x65"];
        $xA1z1 = date("\x59\55\x6d\x2d\144");
        $zz9br = (strtotime($xA1z1) - strtotime($fwYXs)) / (60 * 60 * 24);
        $this->TwoFAUtility->log_debug("\114\157\147\x69\156\120\x6f\x73\164\x20\x3d\x3e\150\141\156\144\x6c\x65\x53\x6b\151\x70\124\x77\157\x46\101\72\x20\103\x6f\x6e\146\151\147\165\162\x65\144\40\x64\141\x74\x65\72\x20" . $fwYXs);
        $this->TwoFAUtility->log_debug("\x4c\x6f\x67\151\x6e\120\157\x73\x74\x20\x3d\76\150\x61\x6e\x64\x6c\x65\x53\x6b\x69\160\x54\167\x6f\x46\x41\x3a\x20\x43\x75\162\162\145\x6e\164\x20\x64\x61\x74\145\x3a\x20" . $xA1z1);
        $this->TwoFAUtility->log_debug("\x4c\x6f\x67\x69\x6e\x50\157\x73\164\40\75\76\x68\x61\156\144\154\x65\123\x6b\151\x70\x54\167\157\x46\x41\72\40\x52\145\155\x61\151\x6e\x69\x6e\x67\x20\144\141\171\163\72\x20" . $zz9br);
        if (!($rm7WT == "\160\145\x72\155\141\x6e\x65\x6e\164" || $zz9br < (int) $rm7WT)) {
            goto vlVvu;
        }
        $this->TwoFAUtility->log_debug("\114\157\x67\151\x6e\x50\x6f\x73\164\40\x3d\x3e\150\141\x6e\144\x6c\x65\x53\153\151\160\x54\x77\157\106\101\72\40\125\163\145\x72\x20\151\163\40\x77\x69\164\150\151\156\x20\164\x68\x65\40\141\154\x6c\157\x77\x65\144\40\163\153\151\160\x20\x70\145\x72\151\157\144\56");
        return $this->defaultLoginFlow($HbQqT);
        vlVvu:
        WsqmG:
        kgghP:
        $this->TwoFAUtility->log_debug("\x4c\x6f\147\151\x6e\120\x6f\163\x74\40\x3d\76\x68\141\x6e\x64\x6c\x65\x53\153\151\x70\x54\x77\157\106\x41\72\x20\x53\x6b\151\x70\x20\62\x46\x41\40\143\x6f\156\x64\x69\x74\x69\x6f\x6e\x73\x20\156\x6f\164\x20\155\145\x74\54\40\x70\162\x6f\143\145\x65\144\151\156\147\40\x77\151\164\150\x20\x6e\157\x72\155\x61\154\x20\146\154\x6f\x77\x2e");
        return false;
    }
    public function check_2fa_disable($d4I2H)
    {
        if (!(isset($d4I2H[0]["\x64\x69\x73\141\x62\154\x65\137\x32\x66\141"]) && $d4I2H[0]["\x64\x69\163\x61\x62\x6c\145\x5f\62\x66\141"] == 1)) {
            goto uOOGa;
        }
        $this->TwoFAUtility->log_debug("\114\157\147\151\x6e\x50\x6f\163\x74\x2e\160\150\x70\x20\72\x20\x65\x78\x65\x63\165\x74\x65\72\x20\62\146\141\x20\151\x73\x20\144\151\163\141\142\154\145\144\x20\146\x6f\162\x20\x74\x68\151\x73\x20\x75\163\x65\x72");
        return true;
        uOOGa:
        return false;
    }
    private function handleExisting2FAUser($HbQqT, $A5AEW, $d4I2H, $fh4cC, $wXpbA)
    {
        $this->TwoFAUtility->log_debug("\105\170\145\x63\x75\164\145\x20\x4c\157\x67\x69\156\120\x6f\x73\x74\72\40\103\x75\163\164\x6f\155\x65\x72\40\x68\141\x73\40\141\154\x72\145\x61\144\171\40\x72\x65\147\151\163\164\145\x72\x65\144\40\x69\156\40\x54\x77\x6f\106\101\x20\155\145\x74\x68\x6f\x64");
        $JtIsS = $d4I2H[0]["\x61\x63\164\x69\x76\145\137\155\145\164\150\157\144"];
        if (!(!isset($JtIsS) || empty($JtIsS) || $JtIsS == NULL)) {
            goto QNfiF;
        }
        $OV54E = $d4I2H[0]["\151\144"];
        $this->TwoFAUtility->deleteRowInTable("\155\151\x6e\x69\157\x72\141\x6e\x67\x65\x5f\x74\146\141\x5f\165\163\145\162\x73", "\x69\144", $OV54E);
        $wXpbA = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $this->messageManager->addError(__("\123\x6f\x6d\x65\164\150\x69\156\x67\x20\x77\145\156\164\x20\167\162\157\x6e\x67\x2e\x50\154\145\x61\x73\x65\x20\154\x6f\147\x69\x6e\40\x61\x67\x61\151\156"));
        $wXpbA->setPath("\143\165\163\x74\x6f\155\x65\x72\x2f\x61\x63\x63\157\165\156\x74\57\154\x6f\x67\x69\x6e");
        return $wXpbA;
        QNfiF:
        $jpBzC = $this->process2FAMethod($d4I2H, $A5AEW, $JtIsS, $fh4cC, $wXpbA);
        return $jpBzC;
    }
    public function process2FAMethod($d4I2H, $A5AEW, $JtIsS, $fh4cC, $wXpbA)
    {
        if ("\107\157\157\147\154\x65\x41\165\x74\150\145\x6e\164\x69\143\141\x74\157\x72" != $JtIsS && "\115\x69\143\162\157\163\x6f\146\164\x41\x75\x74\x68\145\156\x74\151\x63\141\x74\x6f\x72" != $JtIsS) {
            goto IMmqe;
        }
        $dxg2k = ["\x6d\157\x6f\x70\164\151\x6f\156" => "\151\x6e\166\157\x6b\145\x54\106\x41", "\141\143\x74\x69\x76\145\x5f\x6d\145\164\150\x6f\x64" => $JtIsS];
        $this->TwoFAUtility->flushCache();
        $wXpbA->setPath("\x6d\x6f\x74\167\x6f\x66\x61\x2f\155\157\143\x75\163\164\x6f\x6d\145\162\57\151\x6e\x64\145\170", $dxg2k);
        $this->TwoFAUtility->log_debug("\103\x75\162\162\145\156\164\40\x55\122\114\40\75\x3e\40\154\x6f\x67\x69\156\x70\x6f\x73\x74\x20\164\157\40\155\157\x74\x77\x6f\x66\x61\x2f\155\157\x63\165\x73\x74\157\155\x65\x72\x2f\151\x6e\144\145\x78");
        goto BQkX_;
        IMmqe:
        $EmKJo = $this->TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
        $dgru8 = $this->TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
        $qw2gr = $this->TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);
        try {
            if ($EmKJo || $dgru8) {
                goto bFlCS;
            }
            if ($JtIsS === "\117\117\x57") {
                goto xj6aa;
            }
            $jpBzC = $this->handleMiniOrangeGateway($A5AEW, $JtIsS, $fh4cC);
            goto PL399;
            xj6aa:
            $jpBzC = $this->handleWhatsApp2FAMethod($JtIsS, $qw2gr, $d4I2H);
            PL399:
            goto PtBt5;
            bFlCS:
            $jpBzC = $this->handleCustomGateway($d4I2H, $A5AEW, $JtIsS, $fh4cC);
            PtBt5:
        } catch (\Exception $Yz7yp) {
            $this->TwoFAUtility->log_debug("\62\x46\101\40\x6d\145\164\x68\x6f\x64\40\160\x72\x6f\x63\x65\x73\x73\151\x6e\147\x20\x65\x72\x72\157\162\72\x20" . $Yz7yp->getMessage());
            $jpBzC = ["\x73\164\x61\164\x75\x73" => "\106\101\x49\114\105\104", "\155\x65\x73\163\x61\147\x65" => "\123\x6f\x6d\x65\x74\x68\x69\x6e\x67\x20\167\x65\x6e\164\x20\167\162\157\x6e\x67\x2e\x20\x50\154\x65\141\163\145\x20\143\x6f\x6e\164\141\x63\164\40\171\x6f\165\162\x20\141\x64\x6d\x69\x6e\151\163\x74\x72\x61\164\x6f\162\56", "\x74\x78\111\144" => "\61"];
        }
        if ($jpBzC["\x73\x74\141\164\165\x73"] === "\123\x55\x43\x43\105\123\x53") {
            goto gQ7Ci;
        }
        $this->TwoFAUtility->log_debug("\114\x6f\x67\x69\x6e\120\157\163\164\56\x70\x68\x70\x20\72\40\x65\x78\x65\x63\x75\164\x65\72\x20\x55\156\141\x62\x6c\x65\x20\x74\x6f\x20\x73\145\156\144\x20\117\124\120\x2e\x20\120\x6c\145\141\163\145\x20\x63\x6f\x6e\x74\141\x63\164\x20\171\157\x75\x72\40\x41\144\x6d\151\x6e\x69\163\x74\x72\x61\x74\x6f\x72\x2e");
        $this->messageManager->addError(__("\123\157\x6d\x65\x74\150\x69\156\147\40\167\145\x6e\164\x20\167\x72\157\156\x67\56\40\120\x6c\145\x61\x73\145\x20\x63\157\156\x74\141\x63\x74\40\171\157\x75\x72\40\x61\x64\x6d\x69\x6e\151\x73\164\162\141\x74\x6f\x72\x2e"));
        $wXpbA = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $wXpbA->setPath("\143\165\163\164\157\x6d\145\x72\57\141\143\143\x6f\x75\156\x74");
        return $wXpbA;
        goto CRMAd;
        gQ7Ci:
        $this->TwoFAUtility->updateColumnInTable("\x6d\x69\x6e\151\x6f\162\x61\156\147\145\x5f\164\146\x61\x5f\x75\163\x65\162\163", "\x74\x72\x61\156\x73\141\143\164\x69\157\x6e\x49\x64", $jpBzC["\164\170\x49\144"], "\165\x73\x65\162\156\x61\x6d\x65", $A5AEW, $fh4cC);
        $dxg2k = ["\x6d\x6f\157\x70\164\151\157\156" => "\x69\156\x76\157\153\x65\x54\106\101", "\162\x5f\163\164\141\x74\165\163" => $jpBzC["\x73\164\141\164\165\163"], "\141\143\x74\x69\x76\x65\x5f\155\145\164\x68\x6f\144" => $JtIsS, "\145\x6d\x61\151\x6c" => $A5AEW, "\x6d\x65\x73\x73\141\x67\145" => $jpBzC["\155\x65\163\163\x61\x67\145"]];
        if (!($JtIsS === "\117\117\x53" || $JtIsS === "\117\x4f\123\x45")) {
            goto QHEl9;
        }
        $dxg2k["\x70\150\x6f\x6e\145"] = $d4I2H[0]["\x70\x68\x6f\x6e\145"];
        $dxg2k["\x63\x6f\165\156\164\162\171\x63\x6f\144\145"] = $d4I2H[0]["\x63\157\x75\x6e\164\x72\171\x63\x6f\x64\x65"];
        QHEl9:
        $wXpbA->setPath("\x6d\157\164\x77\157\x66\x61\x2f\x6d\157\143\165\163\x74\157\155\145\162\x2f\x69\156\144\145\x78", $dxg2k);
        $this->TwoFAUtility->log_debug("\103\x75\x72\x72\145\x6e\164\x20\x55\122\x4c\40\75\76\40\x6c\157\x67\x69\156\160\x6f\163\164\40\164\x6f\x20\x6d\x6f\x74\x77\x6f\x66\141\x2f\x6d\157\x63\165\x73\164\x6f\x6d\145\162\57\151\x6e\x64\x65\x78");
        CRMAd:
        BQkX_:
        return $wXpbA;
    }
    private function handleCustomGateway($d4I2H, $A5AEW, $JtIsS, $fh4cC)
    {
        $jpBzC = [];
        $EmKJo = $this->TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL);
        $dgru8 = $this->TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS);
        $qw2gr = $this->TwoFAUtility->getStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_WHATSAPP);
        $this->TwoFAUtility->log_debug("\x6c\157\x67\x69\x6e\160\157\163\164\56\x70\x68\160\x20\x3a\x20\145\x78\x65\143\x75\x74\145\x3a\x20\103\165\x73\x74\157\x6d\x20\x67\141\164\145\x77\141\171");
        if ($JtIsS === "\117\x4f\105" && $EmKJo) {
            goto cOeQG;
        }
        if ($JtIsS === "\x4f\x4f\x45") {
            goto hfQ4D;
        }
        goto yLrTx;
        cOeQG:
        $kDlBG = $this->TwoFAUtility->Customgateway_GenerateOTP();
        $WESQR = $A5AEW;
        $jpBzC = $this->customEmail->sendCustomgatewayEmail($WESQR, $kDlBG);
        goto yLrTx;
        hfQ4D:
        $jpBzC = $this->handleMiniOrangeGateway($A5AEW, $JtIsS, $fh4cC);
        yLrTx:
        if ($JtIsS === "\x4f\117\123" && $dgru8) {
            goto ig0OQ;
        }
        if ($JtIsS === "\x4f\117\123") {
            goto w94JO;
        }
        goto frLcK;
        ig0OQ:
        $Mq_Ka = $this->TwoFAUtility->Customgateway_GenerateOTP();
        $eP3Oi = "\x2b" . $d4I2H[0]["\143\157\165\x6e\164\162\171\x63\157\144\x65"] . $d4I2H[0]["\160\150\x6f\x6e\145"];
        $jpBzC = $this->customSMS->send_customgateway_sms($eP3Oi, $Mq_Ka);
        goto frLcK;
        w94JO:
        $jpBzC = $this->handleMiniOrangeGateway($A5AEW, $JtIsS, $fh4cC);
        frLcK:
        if ($JtIsS === "\117\117\127" && $qw2gr) {
            goto UbF9W;
        }
        if ($JtIsS === "\x4f\x4f\127") {
            goto cDGzp;
        }
        goto MT0Ao;
        UbF9W:
        $cGEDv = $this->TwoFAUtility->Customgateway_GenerateOTP();
        $eP3Oi = "\53" . $d4I2H[0]["\x63\157\165\156\x74\x72\171\x63\x6f\144\145"] . $d4I2H[0]["\160\150\x6f\156\145"];
        $jpBzC = $this->TwoFAUtility->send_customgateway_whatsapp($eP3Oi, $cGEDv);
        goto MT0Ao;
        cDGzp:
        $cGEDv = $this->TwoFAUtility->Customgateway_GenerateOTP();
        $jpBzC = $this->TwoFAUtility->send_whatsapp($eP3Oi, $cGEDv);
        MT0Ao:
        if (!($JtIsS == "\x4f\x4f\x53\105")) {
            goto ybl7S;
        }
        $kDlBG = $this->TwoFAUtility->Customgateway_GenerateOTP();
        $WESQR = $A5AEW;
        $eP3Oi = $d4I2H[0]["\x70\150\x6f\156\145"];
        $n8VPH = $d4I2H[0]["\x63\x6f\165\156\x74\x72\171\x63\157\144\145"];
        $eP3Oi = "\x2b" . $n8VPH . $eP3Oi;
        if ($EmKJo) {
            goto nz6B0;
        }
        $pDn2f["\163\x74\x61\x74\x75\x73"] = "\x46\101\111\x4c\x45\104";
        goto rUFZZ;
        nz6B0:
        $pDn2f = $this->customEmail->sendCustomgatewayEmail($WESQR, $kDlBG);
        rUFZZ:
        if ($dgru8) {
            goto WTG1e;
        }
        $N71nX["\x73\164\141\164\x75\x73"] = "\x46\101\x49\x4c\105\x44";
        goto iC1Fz;
        WTG1e:
        $N71nX = $this->customSMS->send_customgateway_sms($eP3Oi, $kDlBG);
        iC1Fz:
        $LtSM0 = $this->TwoFAUtility->OTP_over_SMSandEMAIL_Message($WESQR, $eP3Oi, $pDn2f["\x73\x74\x61\164\x75\163"], $N71nX["\x73\164\x61\164\165\x73"]);
        if ($pDn2f["\163\164\x61\x74\165\163"] == "\123\x55\x43\x43\x45\x53\123" || $N71nX["\163\x74\141\164\x75\x73"] == "\x53\125\103\x43\105\123\x53") {
            goto UY_fO;
        }
        $jpBzC = array("\163\x74\x61\x74\165\163" => "\x46\x41\x49\x4c\x45\104", "\155\x65\163\x73\141\x67\x65" => $LtSM0, "\x74\x78\x49\x64" => "\61");
        goto hYCC9;
        UY_fO:
        $jpBzC = array("\x73\x74\x61\164\165\163" => "\123\125\x43\x43\105\123\x53", "\x6d\145\x73\x73\x61\x67\145" => $LtSM0, "\164\170\x49\x64" => "\x31");
        hYCC9:
        ybl7S:
        if (!($jpBzC["\163\164\141\164\x75\163"] === "\x53\125\x43\x43\x45\x53\123")) {
            goto fsZRd;
        }
        $this->setOtpExpiryTime();
        fsZRd:
        return $jpBzC;
    }
    private function handleMiniOrangeGateway($N_cRc, $JtIsS, $pgSCp)
    {
        try {
            $LhSJy = new MiniOrangeUser();
            $IMYW4 = json_decode($LhSJy->challenge($N_cRc, $this->TwoFAUtility, $JtIsS, true, $pgSCp));
            return ["\x73\x74\x61\x74\x75\x73" => $IMYW4->status, "\x6d\x65\163\x73\x61\147\145" => $IMYW4->message, "\164\170\111\144" => $IMYW4->txId];
        } catch (\Exception $Yz7yp) {
            $this->TwoFAUtility->log_debug("\115\151\x6e\151\117\162\141\x6e\x67\x65\40\x67\x61\x74\145\x77\141\171\40\145\x72\162\x6f\x72\x3a\40" . $Yz7yp->getMessage());
            return ["\163\164\141\x74\x75\163" => "\x46\x41\x49\114\x45\x44", "\155\145\x73\x73\141\147\x65" => "\x53\157\155\x65\164\x68\151\156\147\40\x77\x65\156\x74\40\x77\162\157\156\x67\56\40\x50\x6c\x65\141\x73\x65\x20\x63\157\x6e\x74\141\143\x74\40\171\x6f\165\x72\x20\x61\x64\155\151\156\151\163\x74\x72\x61\164\157\x72\x2e", "\164\170\x49\x64" => "\61"];
        }
    }
    private function setOtpExpiryTime()
    {
        $VQtp1 = 600;
        $OV3RG = time();
        $DbBi0 = $OV3RG + $VQtp1;
        $tHnXj = $VQtp1 % 60;
        $this->TwoFAUtility->log_debug("\x4c\157\147\x69\156\120\157\163\164\x3a\x20\117\124\120\40\145\170\160\151\x72\x79\40\163\x65\x74\40\146\157\162\40{$tHnXj}\40\x73\x65\143\157\x6e\144\163");
        $this->TwoFAUtility->setSessionValue("\157\164\x70\137\x65\x78\x70\x69\162\171\137\x74\151\x6d\145", $DbBi0);
    }
    private function handleWhatsApp2FAMethod($JtIsS, $qw2gr, $d4I2H)
    {
        $cGEDv = $this->TwoFAUtility->Customgateway_GenerateOTP();
        $eP3Oi = $d4I2H[0]["\143\157\x75\156\x74\162\x79\143\x6f\144\145"] . $d4I2H[0]["\x70\x68\157\x6e\145"];
        if ($qw2gr) {
            goto hF6Bt;
        }
        return $this->TwoFAUtility->send_whatsapp($eP3Oi, $cGEDv);
        goto oUSdc;
        hF6Bt:
        return $this->TwoFAUtility->send_customgateway_whatsapp($eP3Oi, $cGEDv);
        oUSdc:
    }
    private function handleNew2FAUser($A5AEW, $niz9v, $fh4cC, $wXpbA)
    {
        $this->TwoFAUtility->log_debug("\x45\x78\x65\x63\165\164\145\x20\114\157\147\151\156\x50\x6f\163\164\72\x20\x43\x75\163\164\x6f\155\x65\x72\40\147\157\x69\156\x67\x20\164\150\162\157\x75\147\150\x20\x49\x6e\154\151\156\145\x20\x66\157\x72\x20\x32\106\101\x20\x73\x65\164\x75\160");
        $jI0Ed = $this->TwoFAUtility->getCustomer2FAMethodsFromRules($niz9v, $fh4cC);
        $Ng22F = $jI0Ed["\143\157\165\x6e\164"];
        $QLYbD = null;
        if (!($Ng22F == 1)) {
            goto vBbkJ;
        }
        $QLYbD = trim($jI0Ed["\155\145\x74\150\157\x64\163"], "\133\x22\x22\x5d");
        vBbkJ:
        if ($Ng22F == 1 && $QLYbD) {
            goto wMOlO;
        }
        if ($Ng22F > 1) {
            goto l02QY;
        }
        $wXpbA->setPath("\143\165\163\164\157\x6d\x65\162\57\141\143\143\157\x75\x6e\164");
        goto sujsG;
        wMOlO:
        $dxg2k = array("\x6d\157\x70\157\163\164\157\x70\164\x69\157\x6e" => "\155\x65\x74\150\x6f\x64", "\x6d\x69\x6e\x69\x6f\x72\x61\x6e\147\145\164\x66\141\x5f\x6d\x65\164\x68\157\144" => $QLYbD, "\x69\x6e\154\x69\156\x65\137\157\156\145\137\x6d\145\x74\150\x6f\144" => "\61", "\145\155\141\x69\x6c" => $A5AEW);
        $wXpbA->setPath("\x6d\157\164\x77\x6f\x66\141\x2f\x6d\x6f\x63\165\x73\164\x6f\155\145\x72", $dxg2k);
        $this->TwoFAUtility->log_debug("\x43\165\162\x72\x65\x6e\164\40\125\122\x4c\40\x3d\x3e\x20\154\157\147\x69\156\x70\157\163\164\x20\164\157\40\155\157\164\167\x6f\146\x61\57\x6d\157\x63\165\163\164\x6f\x6d\x65\162");
        goto sujsG;
        l02QY:
        $dxg2k = array("\155\157\157\160\x74\x69\x6f\x6e" => "\x69\156\x76\x6f\x6b\145\x49\156\154\x69\156\145", "\163\164\x65\160" => "\103\x68\157\x6f\x73\x65\x4d\x46\x41\115\x65\x74\150\157\x64", "\x65\155\x61\x69\x6c" => $A5AEW);
        $wXpbA->setPath("\x6d\x6f\x74\x77\x6f\146\141\x2f\155\x6f\143\165\163\164\x6f\155\x65\x72\x2f\151\156\x64\x65\170", $dxg2k);
        sujsG:
        return $wXpbA;
    }
}