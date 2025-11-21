<?php

namespace MiniOrange\TwoFA\Controller\Actions;

use MiniOrange\TwoFA\Helper\Exception\NotRegisteredException;
use MiniOrange\TwoFA\Helper\Exception\RequiredFieldsException;
abstract class BaseAction extends \Magento\Framework\App\Action\Action
{
    protected $twofautility;
    protected $context;
    public function __construct(\Magento\Framework\App\Action\Context $uchng, \MiniOrange\TwoFA\Helper\TwoFAUtility $zQ8fQ)
    {
        $this->twofautility = $zQ8fQ;
        parent::__construct($uchng);
    }
    public abstract function execute();
    protected function checkIfRequiredFieldsEmpty($q_fcH)
    {
        foreach ($q_fcH as $qix5E => $EicpM) {
            if (!(is_array($EicpM) && (!array_key_exists($qix5E, $EicpM) || $this->twofautility->isBlank($EicpM[$qix5E])) || $this->twofautility->isBlank($EicpM))) {
                goto fSz9k;
            }
            throw new RequiredFieldsException();
            fSz9k:
            WDm56:
        }
        xukml:
    }
    protected function sendHTTPRedirectRequest($SXG0c, $i3aNc)
    {
        $SXG0c = $i3aNc . $SXG0c;
        return $this->resultRedirectFactory->create()->setUrl($SXG0c);
    }
    protected function checkIfValidPlugin()
    {
        if ($this->twofautility->micr()) {
            goto bpVBg;
        }
        throw new NotRegisteredException();
        bpVBg:
    }
}