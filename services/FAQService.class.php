<?php
ini_set( 'error_reporting', E_ALL );
ini_set( 'display_errors', true );

include '../data/FaqData.class.php';
//include '../models/FAQ.class.php';

class FAQService {

    public function getAllFAQs(){
        $faqData = new FAQData();
        $faqsData = $faqData->getAllFAQs();
        $allFAQs = array();

        foreach($faqsData as $faq){
            $newFaq = new FAQ(
                    $faq['idFAQ'],
                    $faq['question'],
                    $faq['answer']
            );

            array_push($allFAQs, $newFaq);
        };

        return $allFAQs;
    }
}

?>