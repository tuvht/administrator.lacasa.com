#! /bin/bash
 
local_file="$(ls $TRAVIS_BUILD_DIR/*.* | head -n 1)"
target_url='ftp://115.84.181.41'
 
echo "Uploading $local_file to $target_url"
curl -u $FTP_USER:$FTP_PASSWORD -T "$local_file" "$target_url"