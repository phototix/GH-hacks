#!/bin/bash

# Specify the source and destination files
src_file="/path/to/source.php"
dest_file="/path/to/destination.php"

# Use the cp command to copy the contents of the source file to the destination file
cp $src_file $dest_file

# Print a success message
echo "Contents of $src_file have been copied to $dest_file."
