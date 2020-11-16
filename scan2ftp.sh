#!/bin/bash
while true; do
  inotifywait -m -r -q --format '%w %f' -e modify,create,delete -r ./app | while read DIR FILE;
  do echo "Upload $FILE to $DIR"
    lftp -e "cd $DIR; put $DIR$FILE; exit" -u user,pass -p 99921 host;
  done;
done
