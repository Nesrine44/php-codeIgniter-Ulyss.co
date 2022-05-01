<?php
//$docObj = new DocxConversion("test.docx");
//$docObj->getHTML();


class DocxConversion{
    private $filename;

    public function __construct($filePath) {
        $this->filename = $filePath;
        //echo "DocxConversion[ ".$this->filename." ]";
    }

    public function getHTML(){
        $docText= $this->convertToText();
        return $this->xmlToHtml($docText);
    }

    

    private function read_doc() {
        $fileHandle = fopen($this->filename, "r");
        $line = @fread($fileHandle, filesize($this->filename));   
        $lines = explode(chr(0x0D),$line);
        $outtext = "";
        foreach($lines as $thisline)
          {
            $pos = strpos($thisline, chr(0x00));
            if (($pos !== FALSE)||(strlen($thisline)==0))
              {
              } else {
                $outtext .= $thisline." ";
              }
          }
         $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
        return $outtext;
    }

    private function read_docx(){

        $striped_content = '';
        $content = '';

        $zip = zip_open($this->filename);

        if (!$zip || is_numeric($zip)) return false;

        while ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

            if (zip_entry_name($zip_entry) != "word/document.xml") continue;

            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            zip_entry_close($zip_entry);
        }// end while

        zip_close($zip);

        return $content;

        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $striped_content = strip_tags($content);

        return $striped_content;
    }

 /************************excel sheet************************************/

function xlsx_to_text($input_file){
    $xml_filename = "xl/sharedStrings.xml"; //content file name
    $zip_handle = new ZipArchive;
    $output_text = "";
    if(true === $zip_handle->open($input_file)){
        if(($xml_index = $zip_handle->locateName($xml_filename)) !== false){
            $xml_datas = $zip_handle->getFromIndex($xml_index);
            $xml_handle = DOMDocument::loadXML($xml_datas, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            $output_text = strip_tags($xml_handle->saveXML());
        }else{
            $output_text .="";
        }
        $zip_handle->close();
    }else{
    $output_text .="";
    }
    return $output_text;
}

/*************************power point files*****************************/
function pptx_to_text($input_file){
    $zip_handle = new ZipArchive;
    $output_text = "";
    if(true === $zip_handle->open($input_file)){
        $slide_number = 1; //loop through slide files
        while(($xml_index = $zip_handle->locateName("ppt/slides/slide".$slide_number.".xml")) !== false){
            $xml_datas = $zip_handle->getFromIndex($xml_index);
            $xml_handle = DOMDocument::loadXML($xml_datas, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            $output_text .= strip_tags($xml_handle->saveXML());
            $slide_number++;
        }
        if($slide_number == 1){
            $output_text .="";
        }
        $zip_handle->close();
    }else{
    $output_text .="";
    }
    return $output_text;
}


    public function convertToText() {

        if(isset($this->filename) && !file_exists($this->filename)) {
            return "File Not exists";
        }

        $fileArray = pathinfo($this->filename);
        $file_ext  = $fileArray['extension'];
        if($file_ext == "doc" || $file_ext == "docx" || $file_ext == "xlsx" || $file_ext == "pptx")
        {
            if($file_ext == "doc") {
                return $this->read_doc();
            } elseif($file_ext == "docx") {
                return $this->read_docx();
            } elseif($file_ext == "xlsx") {
                return $this->xlsx_to_text();
            }elseif($file_ext == "pptx") {
                return $this->pptx_to_text();
            }
        } else {
            return "Invalid File Type";
        }
    }


    public function xmlToHtml($docText){

    $reader = new XMLReader;
    $reader->xml($docText);
    


    // set up variables for formatting
    $text = ''; $formatting['bold'] = 'closed'; $formatting['italic'] = 'closed'; $formatting['underline'] = 'closed'; $formatting['header'] = 0;
    
    // loop through docx xml dom
    while ($reader->read()){ 
        // look for new paragraphs
        if ($reader->nodeType == XMLREADER::ELEMENT && $reader->name === 'w:p'){ 
            // set up new instance of XMLReader for parsing paragraph independantly
            $paragraph = new XMLReader;
            $p = $reader->readOuterXML();
            $paragraph->xml($p);
            
            // search for heading
            preg_match('/<w:pStyle w:val="(Heading.*?[1-6])"/',$p,$matches);
            if (isset($matches[1])) {
                switch($matches[1]){
                case 'Heading1': $formatting['header'] = 1; break;
                case 'Heading2': $formatting['header'] = 2; break;
                case 'Heading3': $formatting['header'] = 3; break;
                case 'Heading4': $formatting['header'] = 4; break;
                case 'Heading5': $formatting['header'] = 5; break;
                case 'Heading6': $formatting['header'] = 6; break;
                default:  $formatting['header'] = 0; break;
                }
            }
            
            
            // open h-tag or paragraph
            
            $pOpened = false;
            $pStyle = '';


            
            // loop through paragraph dom
            while ($paragraph->read()){
                // look for elements
                
             
               // if ($paragraph->nodeType == XMLREADER::ELEMENT) echo $paragraph->name;

                if ($paragraph->nodeType == XMLREADER::ELEMENT && $paragraph->name === 'w:pPr'){
                       //echo "FOUND";
                    $paragraph_style = new XMLReader;
                    $ps = $paragraph->readOuterXML();
                    //echo $ps;
                    $paragraph_style->xml($ps);
                         while ($paragraph_style->read()){

                            if ($paragraph_style->nodeType == XMLREADER::ELEMENT && $paragraph_style->name === 'w:spacing'){
                            }
                            if ($paragraph_style->nodeType == XMLREADER::ELEMENT && $paragraph_style->name === 'w:jc'){
                                //echo "paragraphFOUND";
                                $text_align = $paragraph_style->getAttribute('w:val');
                                //echo $text_align;
                            }

                         }

                    $pStyle = 'text-align:right';
                    //$text .=$pStyle;
                    
                }



                if(!$pOpened) {
                    //$text .= $paragraph->name;

                    $text .= ($formatting['header'] > 0) ? '<h'.$formatting['header'].'>' : '<p style="'.$pStyle.'">';($formatting['header'] > 0) ? '<h'.$formatting['header'].'>' : '<p style="'.$pStyle.'">';
                }
                $pOpened = true;

                if ($paragraph->nodeType == XMLREADER::ELEMENT && $paragraph->name === 'w:r'){
                    $node = trim($paragraph->readInnerXML());
 
                    // add <br> tags
                    if (strstr($node,'<w:br ')) $text .= '<br>';
 
                    // look for formatting tags                    
                    $formatting['bold'] = (strstr($node,'<w:b/>')) ? (($formatting['bold'] == 'closed') ? 'open' : $formatting['bold']) : (($formatting['bold'] == 'opened') ? 'close' : $formatting['bold']);
                    $formatting['italic'] = (strstr($node,'<w:i/>')) ? (($formatting['italic'] == 'closed') ? 'open' : $formatting['italic']) : (($formatting['italic'] == 'opened') ? 'close' : $formatting['italic']);
                    $formatting['underline'] = (strstr($node,'<w:u ')) ? (($formatting['underline'] == 'closed') ? 'open' : $formatting['underline']) : (($formatting['underline'] == 'opened') ? 'close' : $formatting['underline']);
                    
                    // build text string of doc
                    $text .=     (($formatting['bold'] == 'open') ? '<strong>' : '').
                                (($formatting['italic'] == 'open') ? '<em>' : '').
                                (($formatting['underline'] == 'open') ? '<u>' : '').
                                htmlentities(iconv('UTF-8', 'ASCII//TRANSLIT',$paragraph->expand()->textContent)).
                                (($formatting['underline'] == 'close') ? '</u>' : '').
                                (($formatting['italic'] == 'close') ? '</em>' : '').
                                (($formatting['bold'] == 'close') ? '</strong>' : '');
                    
                    // reset formatting variables
                    foreach ($formatting as $key=>$format){
                        if ($format == 'open') $formatting[$key] = 'opened';
                        if ($format == 'close') $formatting[$key] = 'closed';
                    }
                }    
            }        
            $text .= ($formatting['header'] > 0) ? '</h'.$formatting['header'].'>' : '</p>';
        }
    
    }
    $reader->close();

   // echo "XML".$reader->readOuterXML();
    
    // suppress warnings. loadHTML does not require valid HTML but still warns against it...
    // fix invalid html
    $doc = new DOMDocument();
    $doc->encoding = 'UTF-8';
    @$doc->loadHTML($text);
    $goodHTML = simplexml_import_dom($doc)->asXML();

    return $goodHTML;
    }

}

?>