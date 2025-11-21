<?php

namespace MiniOrange\TwoFA\Helper;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Email\Model\Template\SenderResolver;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
class CustomEmail extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $inlineTranslation;
    protected $escaper;
    protected $transportBuilder;
    protected $logger;
    protected $twofautility;
    protected $email_sent_in_message = '';
    protected $senderResolver;
    protected $emailTemplate;
    protected $storeManager;
    protected $customerRepository;
    public function __construct(Context $j7tKv, \MiniOrange\TwoFA\Helper\TwoFAUtility $VXNWJ, \Magento\Email\Model\BackendTemplate $h2QFs, StateInterface $LwOIL, Escaper $u9LIy, TransportBuilder $sm1YO, SenderResolver $iK9JM, \Magento\Store\Model\StoreManagerInterface $aPzRe, CustomerRepositoryInterface $M3ZhT)
    {
        parent::__construct($j7tKv);
        $this->twofautility = $VXNWJ;
        $this->inlineTranslation = $LwOIL;
        $this->escaper = $u9LIy;
        $this->emailTemplate = $h2QFs;
        $this->transportBuilder = $sm1YO;
        $this->senderResolver = $iK9JM;
        $this->logger = $j7tKv->getLogger();
        $this->storeManager = $aPzRe;
        $this->customerRepository = $M3ZhT;
    }
    public function sendCustomgatewayEmail($H3CRZ, $kIsCt)
    {
        $qcU0n = $this->twofautility->check_customGateway_methodConfigured();
        if (!$qcU0n) {
            goto BsCvT;
        }
        $pGw_z = array("\163\x74\x61\164\x75\x73" => "\x46\101\111\x4c\x45\x44", "\x6d\145\163\163\x61\147\145" => "\116\157\x20\143\x75\x73\164\157\155\x20\147\x61\x74\145\167\141\x79\x20\155\x65\x74\150\x6f\144\40\x63\x6f\x6e\x66\151\x67\x75\162\145\x64\x20\146\x6f\x72\x20\105\x6d\141\x69\154\x2e", "\164\170\111\144" => "\x31", "\164\x65\x63\x68\137\155\x65\163\x73\141\x67\145" => "\116\157\40\143\x75\x73\164\157\x6d\40\x67\141\164\x65\x77\x61\171\x20\x6d\x65\x74\x68\x6f\144\40\143\x6f\x6e\x66\x69\x67\x75\x72\145\x64\x20\146\157\x72\x20\105\x6d\x61\x69\154\x2e");
        return $pGw_z;
        BsCvT:
        $DbGRr = '';
        try {
            $KwgGq = $this->twofautility->getStoreConfig(TwoFAConstants::SELECTED_TEMPLATE_ID);
            $by6AM = $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_EMAIL_FROM);
            $P55hG = $this->twofautility->getStoreConfig(TwoFAConstants::CUSTOMGATEWAY_EMAIL_NAME);
            $this->twofautility->log_debug("\103\165\x73\164\157\155\x65\162\x45\155\141\x69\x6c\56\160\150\160\x20\x63\150\145\x63\153\151\156\x67\40\x65\x6d\x61\151\x6c\x20\x76\141\162\151\141\142\x6c\145\40\137\x74\x6f\40\x3a\x20" . $H3CRZ);
            $QARW0 = explode("\100", $H3CRZ);
            if (isset($QARW0[0], $QARW0[1])) {
                goto efqXn;
            }
            $DbGRr = $H3CRZ;
            goto w3SND;
            efqXn:
            $this->twofautility->log_debug("\103\x75\x73\x74\x6f\155\145\x72\x45\x6d\141\x69\154\56\160\x68\160\40\x63\150\145\x63\153\x69\x6e\147\40\x65\x6d\141\x69\154\x20\166\x61\x6c\165\145\x20\44\x70\141\x72\164\x73\40\72\40" . print_r($QARW0, true));
            $DbGRr = $QARW0[0][0] . "\x78\x78\x78\170\x78\x78\x78\170\x78\170\100" . $QARW0[1];
            w3SND:
            $this->twofautility->log_debug("\x43\165\163\x74\x6f\155\x65\x72\x45\x6d\141\x69\x6c\56\x70\x68\160\40\143\150\145\x63\153\151\156\147\40\x65\155\141\x69\154\x20\x76\141\x6c\165\x65\x20\x76\141\x72\151\x62\154\x65\40\x65\x6d\141\151\x6c\x5f\x73\145\156\164\137\151\x6e\x5f\x6d\145\x73\x73\141\147\145\x20\72\x20" . $DbGRr);
            $AygHG = ["\156\141\155\x65" => $this->escaper->escapeHtml($P55hG), "\x65\155\x61\151\x6c" => $this->escaper->escapeHtml($by6AM)];
            $cp2uP = $this->getcustomerFullname($H3CRZ);
            $this->twofautility->log_debug("\103\165\x73\164\157\x6d\145\162\105\155\x61\151\154\x2e\x70\x68\160\40\x63\x68\x65\x63\x6b\x69\156\147\x20\x63\x75\163\164\x6f\155\145\162\x20\x6e\x61\155\x65\40\166\141\162\151\x61\x62\154\x65\x20\143\x75\x73\164\x6f\155\145\162\137\156\141\155\x65\x20\72\x20" . $cp2uP);
            $OnJZd = $this->transportBuilder->setTemplateIdentifier($KwgGq)->setTemplateOptions(["\x61\x72\x65\x61" => \Magento\Framework\App\Area::AREA_FRONTEND, "\x73\164\157\162\145" => $this->storeManager->getStore()->getId()])->setTemplateVars(["\157\x74\160" => $kIsCt, "\145\x6d\141\151\x6c" => $H3CRZ, "\163\164\157\x72\145" => $this->storeManager->getStore()])->setFrom($AygHG)->addTo($H3CRZ)->getTransport();
            $OnJZd->sendMessage();
            $this->twofautility->log_debug("\155\x69\156\151\157\162\x61\156\147\x65\x20\x63\165\x73\164\x6f\155\40\145\x6d\x61\151\x6c\40\163\145\x6e\144\40\x73\x75\x63\x63\x65\163\146\165\154\154\154\x79\72");
            $pGw_z = array("\x73\164\141\x74\165\163" => "\x53\x55\x43\x43\x45\x53\x53", "\x6d\x65\163\163\141\x67\145" => "\124\150\x65\40\117\x54\x50\40\150\141\163\40\x62\x65\145\156\40\163\145\x6e\164\x20\x74\x6f\x20" . $DbGRr . "\56\40\x50\x6c\x65\141\163\x65\x20\145\x6e\164\145\162\x20\x74\150\145\40\117\124\120\40\x79\157\165\x20\x72\x65\x63\x65\151\166\145\x64\40\x74\x6f\x20\x76\x61\154\151\x64\x61\164\x65\x2e", "\164\x78\x49\x64" => "\x31");
            return $pGw_z;
        } catch (\Exception $xHhC5) {
            $this->twofautility->log_debug("\x43\165\x73\164\x6f\155\x45\x4d\x41\111\x4c\x3a\145\162\x72\157\x72\x20\x6d\x65\x73\x73\141\147\145\x3a" . $xHhC5->getMessage());
            if ($DbGRr) {
                goto gj6C7;
            }
            $DbGRr = $H3CRZ;
            goto m42m2;
            gj6C7:
            $this->twofautility->log_debug("\x43\165\163\x74\157\x6d\x65\x72\105\x6d\141\151\x6c\x2e\x70\150\x70\x20\x63\x68\x65\x63\153\151\156\147\x20\x65\x6d\141\x69\x6c\40\166\x61\162\141\x69\x61\x62\154\x65\40\145\x6d\141\151\x6c\x5f\x73\x65\156\164\137\x69\156\137\x6d\145\163\163\141\x67\x65\x20\x69\156\x20\x63\x61\x74\x63\x68\x20\72\40" . $DbGRr);
            m42m2:
            $pGw_z = array("\163\x74\x61\164\165\x73" => "\106\101\x49\x4c\105\x44", "\x6d\145\x73\163\141\147\x65" => "\106\x61\154\x69\145\144\x20\164\x6f\x20\x73\x65\156\144\40\117\x54\120\x20\x74\x6f\40" . $DbGRr . "\56\x20\120\x6c\x65\141\163\x65\x20\103\157\x6e\x74\x61\x63\x74\40\x59\x6f\165\162\40\101\x64\155\151\x6e\151\x73\x74\x72\x61\x74\157\x72\x2e", "\164\x78\111\x64" => "\x31", "\164\145\143\x68\137\x6d\x65\x73\x73\141\x67\145" => $xHhC5->getMessage());
            return $pGw_z;
        }
    }
    public function getcustomerFullname($H3CRZ)
    {
        try {
            $el4jr = $this->customerRepository->get($H3CRZ);
            $uTnPr = $el4jr->getFirstname() . "\40" . $el4jr->getLastname();
        } catch (\Magento\Framework\Exception\NoSuchEntityException $xHhC5) {
            $uTnPr = "\124\145\x73\164\151\156\x67";
        }
        return $uTnPr;
    }
}