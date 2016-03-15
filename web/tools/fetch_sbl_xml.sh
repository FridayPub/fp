#!/bin/bash

#URL="http://www.systembolaget.se/Assortment.aspx?Format=Xml"
URL="http://www.systembolaget.se/api/assortment/products/xml"
XML_FILE_PATH="../xml/"
XML_FILE="sbl-`date '+20%y-%m-%d'`.xml"
#XML_LINK="sbl-latest.xml"

function print_and_exit {
    msg="$1"; shift

    echo "Systembolaget XML update error: $msg"
    exit 1;
}

wget $URL -O $XML_FILE_PATH$XML_FILE
[ "$?" == "0" ] || print_and_exit "wget"

# Setup soft link to point to latest version
#rm ../xml/sbl-latest.xml 2>/dev/null
#ln -s $XML_FILE sbl-latest.xml

# Remove double quotes around strings
sed 's#&quot;##g' -i $XML_FILE_PATH$XML_FILE
[ "$?" == "0" ] || print_and_exit "sed"

# Move XML file to xml folder
#mv $XML_FILE ../xml/$XML_FILE
#[ "$?" == "0" ] || print_and_exit "mv file"

# Move link to latest XML to xml folder
#mv $XML_LINK ../xml/$XML_LINK
#[ "$?" == "0" ] || print_and_exit "mv link"
