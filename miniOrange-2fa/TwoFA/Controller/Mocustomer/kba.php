<?php

namespace MiniOrange\TwoFA\Controller\Mocustomer;

use Magento\Customer\Model\Customer;
use Magento\Customer\Model\Session;
use Magento\Framework\App\RequestInterface;
use MiniOrange\TwoFA\Controller\Mocustomer\TwoFAConstants;
use MiniOrange\TwoFA\Helper\MiniOrangeInline;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
class KBA extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $request;
    protected $resultFactory;
    protected $storeManager;
    protected $messageManager;
    private $TwoFAUtility;
    private $miniOrangeInline;
    private $customerModel;
    private $customerSession;
    private $url;
    private $responseFactory;
    public function __construct(\Magento\Framework\App\Action\Context $Gx04L, \Magento\Framework\View\Result\PageFactory $xilu6, \Magento\Framework\Message\ManagerInterface $fF3jv, \Magento\Framework\App\ResponseFactory $PC6RJ, RequestInterface $h0ukl, TwoFAUtility $vU2R0, MiniOrangeInline $I50BM, Customer $V3s6Q, Session $nyHFe, \Magento\Framework\Controller\ResultFactory $G8m5K, \Magento\Framework\UrlInterface $RTDz2, \Magento\Store\Model\StoreManagerInterface $SAbeG)
    {
        $this->_pageFactory = $xilu6;
        $this->messageManager = $fF3jv;
        $this->responseFactory = $PC6RJ;
        $this->request = $h0ukl;
        $this->TwoFAUtility = $vU2R0;
        $this->customerModel = $V3s6Q;
        $this->miniOrangeInline = $I50BM;
        $this->customerSession = $nyHFe;
        $this->resultFactory = $G8m5K;
        $this->url = $RTDz2;
        $this->storeManager = $SAbeG;
        parent::__construct($Gx04L);
    }
    public function execute()
    {
        $this->TwoFAUtility->log_debug("\115\157\143\x75\x73\x74\x6f\x6d\x65\162\72\113\102\x41\40\115\145\164\x68\x6f\144");
        $ceInS = $this->request->getPostValue();
        $X7htP = $this->request->getParams();
        if (!(isset($ceInS["\x69\156\x76\157\x6b\x65\137\x6b\142\141\x5f\x76\x61\154\x69\x64\x61\x74\x65"]) || isset($X7htP["\151\156\166\x6f\153\x65\137\153\x62\141\137\166\x61\x6c\151\x64\x61\x74\145"]))) {
            goto chkLW;
        }
        $rayZq = $this->TwoFAUtility->getSessionValue("\x6d\157\x75\163\145\x72\156\141\x6d\x65");
        $mTxAp = $this->TwoFAUtility->getCustomerMoTfaUserDetails("\155\x69\156\151\157\162\x61\x6e\x67\x65\137\164\146\x61\x5f\x75\163\145\x72\163", $rayZq);
        if (!(is_array($mTxAp) && sizeof($mTxAp) > 0)) {
            goto wA_iI;
        }
        if ($mTxAp[0]["\153\142\141\x5f\x6d\145\164\150\157\144"] != NULL && $mTxAp[0]["\153\x62\x61\137\155\145\x74\x68\157\144"] != '') {
            goto FucZS;
        }
        $CvUS0 = $this->resultRedirectFactory->create();
        $this->messageManager->addError(__("\x59\x6f\165\40\x64\157\40\156\x6f\x74\x20\150\141\166\145\x20\142\141\143\153\x75\x70\40\x6f\160\x74\x69\x6f\156\56\x20\x50\154\145\x61\x73\145\40\143\157\156\x74\x61\143\x74\40\171\157\165\x20\141\x64\x6d\x69\x6e\151\163\x74\162\141\164\157\x72"));
        $CvUS0->setPath("\143\165\163\164\157\x6d\x65\x72\x2f\141\143\143\157\x75\x6e\x74\57\x6c\x6f\147\151\x6e");
        return $CvUS0;
        goto F_dRq;
        FucZS:
        $XUuG8 = $this->url->getUrl("\155\x6f\164\167\x6f\146\x61\57\x6d\157\x63\165\x73\164\157\155\145\x72") . "\77\46\x6d\157\x6f\x70\164\151\x6f\156\x3d\151\156\x76\x6f\153\x65\x49\156\154\x69\156\145\x26\163\164\x65\x70\x3d\113\x42\x41\137\126\141\154\151\x64\x61\164\x65";
        $iYcmJ = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $iYcmJ->setUrl($XUuG8);
        return $iYcmJ;
        F_dRq:
        wA_iI:
        chkLW:
        $rayZq = $this->TwoFAUtility->getSessionValue("\155\x6f\x75\163\x65\x72\x6e\x61\x6d\x65");
        $mTxAp = $this->TwoFAUtility->getCustomerMoTfaUserDetails("\155\151\x6e\x69\157\162\x61\156\147\145\x5f\164\146\141\x5f\165\163\145\162\163", $rayZq);
        if (!(is_array($mTxAp) && sizeof($mTxAp) > 0)) {
            goto CAPtW;
        }
        $TtOGM = $mTxAp[0]["\153\x62\141\x5f\x6d\x65\x74\x68\157\x64"];
        $TtOGM = json_decode($TtOGM, true);
        CAPtW:
        $MXBJU = trim($TtOGM[$ceInS["\161\61"]]["\x61\x6e\x73\167\145\162"]);
        $PwIID = trim($TtOGM[$ceInS["\161\62"]]["\x61\156\163\167\x65\162"]);
        $iw8XC = trim($ceInS["\141\156\x73\x77\x65\x72\61"]);
        $VSyMy = trim($ceInS["\x61\x6e\x73\x77\145\x72\x32"]);
        $IrvYw = NULL;
        $CMm92 = NULL;
        $JS0lg = strcasecmp($MXBJU, $iw8XC);
        $QcgwU = strcasecmp($PwIID, $VSyMy);
        if ($JS0lg == "\x30" && $QcgwU == "\60") {
            goto mDHOk;
        }
        $CvUS0 = $this->resultRedirectFactory->create();
        $this->messageManager->addError(__("\120\154\x65\141\x73\x65\40\x45\x6e\164\145\x72\40\103\157\x72\x72\x65\x63\164\40\166\x61\154\165\x65\x73\x20\x69\x6e\40\x4b\102\101\x2e"));
        $CvUS0->setPath("\143\165\x73\x74\x6f\x6d\145\x72\x2f\x61\x63\x63\157\165\x6e\x74\x2f\x6c\x6f\147\x69\x6e");
        return $CvUS0;
        goto D02M9;
        mDHOk:
        if (!(isset($X7htP["\162\145\155\145\x6d\142\x65\162\x44\x65\166\x69\143\145"]) && $X7htP["\162\x65\155\145\155\x62\x65\162\x44\x65\x76\x69\143\x65"] == "\61")) {
            goto kvXcL;
        }
        $this->TwoFAUtility->log_debug("\x4d\x6f\103\x75\163\x74\x6f\x6d\145\x72\40\x4b\x42\101\x3a\40\x20\x76\141\x6c\x69\x64\141\x74\x65\40\153\x62\141\40\x71\x75\x65\x73\x74\x69\157\x6e\40\141\x6e\144\x20\x72\145\155\x65\155\x65\x72\40\104\145\166\151\143\x65\x20\x69\x73\40\x73\x65\164\40\142\171\40\x63\165\163\164\157\x6d\x65\162\40\x20");
        $this->TwoFAUtility->check_and_save_device_data('', $rayZq, $mTxAp[0]["\x77\145\142\x73\x69\x74\x65\137\x69\144"], $mTxAp);
        kvXcL:
        $user = $this->getCustomerFromAttributes($this->TwoFAUtility->getSessionValue("\155\157\x75\163\145\x72\x6e\x61\x6d\x65"));
        $this->customerSession->setCustomerAsLoggedIn($user);
        $XUuG8 = $this->url->getUrl("\143\165\163\x74\x6f\155\145\162\57\x61\x63\143\157\165\156\x74");
        $iYcmJ = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $iYcmJ->setUrl($XUuG8);
        return $iYcmJ;
        D02M9:
    }
    private function getCustomerFromAttributes($gtcMd)
    {
        $this->TwoFAUtility->log_debug("\115\x6f\143\165\x73\164\157\155\145\162\72\x20\x67\145\x74\103\x75\x73\164\157\x6d\x65\162\x46\x72\157\x6d\101\164\x74\x72\151\x62\165\164\x65\163");
        $this->customerModel->setWebsiteId($this->storeManager->getStore()->getWebsiteId());
        $AFIci = $this->customerModel->loadByEmail($gtcMd);
        return !is_null($AFIci->getId()) ? $AFIci : false;
    }
}