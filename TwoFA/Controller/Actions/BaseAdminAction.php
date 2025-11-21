<?php

namespace MiniOrange\TwoFA\Controller\Actions;

use MiniOrange\TwoFA\Helper\Exception\NotRegisteredException;
use MiniOrange\TwoFA\Helper\Exception\RequiredFieldsException;
use MiniOrange\TwoFA\Helper\Exception\SupportQueryRequiredFieldsException;
abstract class BaseAdminAction extends \Magento\Backend\App\Action
{
    protected $twofautility;
    protected $context;
    protected $resultPageFactory;
    protected $messageManager;
    protected $logger;
    public function __construct(\Magento\Backend\App\Action\Context $N43CP, \Magento\Framework\View\Result\PageFactory $P93Ph, \MiniOrange\TwoFA\Helper\TwoFAUtility $myr7C, \Magento\Framework\Message\ManagerInterface $qaoOh, \Psr\Log\LoggerInterface $ExQ73)
    {
        $this->twofautility = $myr7C;
        $this->resultPageFactory = $P93Ph;
        $this->messageManager = $qaoOh;
        $this->logger = $ExQ73;
        parent::__construct($N43CP);
    }
    public function checkIfSupportQueryFieldsEmpty($eXUNt)
    {
        try {
            $this->checkIfRequiredFieldsEmpty($eXUNt);
        } catch (RequiredFieldsException $CanTd) {
            throw new SupportQueryRequiredFieldsException();
        }
    }
    protected function checkIfRequiredFieldsEmpty($eXUNt)
    {
        foreach ($eXUNt as $nj8SI => $nMfmf) {
            if (!(is_array($nMfmf) && (!array_key_exists($nj8SI, $nMfmf) || $this->twofautility->isBlank($nMfmf[$nj8SI])) || $this->twofautility->isBlank($nMfmf))) {
                goto tBm22;
            }
            throw new RequiredFieldsException();
            tBm22:
            H96fZ:
        }
        fjy2j:
    }
    public abstract function execute();
    protected function isFormOptionBeingSaved($e43O1)
    {
        return array_key_exists("\157\160\x74\x69\157\x6e", $e43O1);
    }
    protected function checkIfValidPlugin()
    {
        if ($this->twofautility->micr()) {
            goto bV0FG;
        }
        throw new NotRegisteredException();
        bV0FG:
    }
}