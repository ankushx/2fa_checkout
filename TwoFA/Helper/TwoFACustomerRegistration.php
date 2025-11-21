<?php

namespace MiniOrange\TwoFA\Helper;

use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
class TwoFACustomerRegistration
{
    protected $twofautility;
    protected $context;
    protected $customerFactory;
    protected $storeManager;
    protected $customerRepository;
    public function __construct(Context $Nyepx, \MiniOrange\TwoFA\Helper\TwoFAUtility $s7vUh, CustomerFactory $XA1c8, StoreManagerInterface $nEU2c, \Magento\Customer\Api\CustomerRepositoryInterface $uZPET)
    {
        $this->context = $Nyepx;
        $this->twofautility = $s7vUh;
        $this->customerFactory = $XA1c8;
        $this->storeManager = $nEU2c;
        $this->customerRepository = $uZPET;
    }
    public function execute()
    {
    }
    public function createNewCustomerAtRegistration()
    {
        $bcGHD = 1;
        $ohuOe = json_decode($this->twofautility->getSessionValue("\x6d\157\x5f\x63\x75\x73\164\157\155\145\x72\x5f\160\x61\x67\x65\x5f\160\x61\x72\141\155\x65\164\145\x72\x73"), true);
        $NTuq3 = $ohuOe["\x65\155\141\x69\154"];
        $Y7Fi5 = $ohuOe["\146\x69\162\163\x74\x6e\141\x6d\145"];
        $qyRGG = $ohuOe["\x6c\x61\x73\164\156\x61\155\145"];
        $i8Pve = $ohuOe["\160\141\x73\163\167\x6f\x72\x64"];
        $qaFZI = $this->storeManager->getWebsite()->getWebsiteId();
        $vnOhi = $this->storeManager->getStore();
        $Dwlh0 = $this->customerFactory->create()->setWebsiteId($qaFZI)->setStore($vnOhi)->setEmail($NTuq3)->setFirstname($Y7Fi5)->setLastname($qyRGG)->setPassword($i8Pve)->setGroupId($bcGHD)->save();
        $this->checkAndProcessB2BFlow($Dwlh0);
    }
    public function checkAndProcessB2BFlow($Dwlh0)
    {
        if ($this->twofautility->isCommerceEdition()) {
            goto CrZ2k;
        }
        return;
        CrZ2k:
        $this->twofautility->log_debug("\123\x65\x74\164\x69\156\x67\x20\143\x75\163\x74\157\x6d\145\x72\x20\x61\163\40\x42\x32\x43\40\146\157\162\x20\x54\167\x6f\106\101\40\155\157\144\165\154\x65");
        try {
            $pDKQn = $this->customerRepository->getById($Dwlh0->getId());
            $Z3ebg = $this->twofautility->saveCustomerAsB2CUser($pDKQn, $Dwlh0->getId());
            $this->customerRepository->save($pDKQn);
        } catch (\Exception $VxCR2) {
            $this->twofautility->log_debug("\105\x72\162\157\x72\x20\x73\x61\x76\x69\x6e\x67\x20\x42\62\x43\x20\143\x75\163\x74\157\x6d\145\162\x3a\x20" . $VxCR2->getMessage());
        }
    }
}