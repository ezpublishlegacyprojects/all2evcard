<?php

$ini = eZINI::instance( 'all2evcard.ini' );

$class = $Params['Class'];
$nodeID = $Params['NodeID'];

if( $nodeID && $class )
{    
    $identifiers = $ini->group( $class );
       
    if( $identifiers && is_array( $identifiers ) )
    {        
        $node = eZContentObjectTreeNode::fetch( $nodeID );

        if( is_object( $node ) )
        {
            $contentObject = $node->attribute( 'object' );
            $dataMap = $contentObject->attribute( 'data_map' );

            $content = "BEGIN:VCARD";
            $content .= "\nVERSION:2.1\n";
            $content .= "N:".$dataMap[$identifiers['LastName']]->content().';'.$dataMap[$identifiers['FirstName']]->content().';;'.$dataMap[$identifiers['Salutation']]->content()."\n";
            $content .= "FN:".$dataMap[$identifiers['FirstName']]->content()." ".$dataMap[$identifiers['LastName']]->content()."\n";
            $content .= "TITLE:".$dataMap[$identifiers['Title']]->content()."\n";
            $content .= "TEL;WORK;VOICE:".$dataMap[$identifiers['Phone']]->content()."\n";
            $content .= "TEL;WORK;FAX:".$dataMap[$identifiers['Fax']]->content()."\n";
            $content .= "EMAIL;INTERNET:".$dataMap[$identifiers['Email']]->content()."\n";
            $content .= "ADR;WORK;PREF;CHARSET=".$ini->variable( 'VcardSettings', 'DefaultCharset' ).":;;".$dataMap[$identifiers['Street']]->content()." ".$dataMap[$identifiers['HouseNumber']]->content().";".$dataMap[$identifiers['City']]->content().";;".$dataMap[$identifiers['ZIP']]->content().";\n";
            $content .= "LABEL;WORK;PREF;CHARSET=".$ini->variable( 'VcardSettings', 'DefaultCharset' ).";".$dataMap[$identifiers['Street']]->content()." ".$dataMap[$identifiers['HouseNumber']]->content()."\n".$dataMap[$identifiers['ZIP']]->content()." ".$dataMap[$identifiers['City']]->content()."\n";
            $content .= "END:VCARD";

            $content = mb_convert_encoding( $content, 'ISO-8859-1', mb_detect_encoding( $content ) );

            echo $content;

            header( 'Cache-Control: maxage=3600' );
            header( 'Content-Transfer-Encoding: binary' );
            header( 'Content-type: text/x-vcard;' );
            header( 'Content-Disposition: attachment; filename="'.$node->attribute( 'name' ).'.vcf"' ); 
        }
    }
}

$Result = array();
$Result['pagelayout'] = false;

?>
