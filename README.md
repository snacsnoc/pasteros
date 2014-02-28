This is the source code for paste.gelat.in

Configuration for PostgreSQL is in `public/index.php`. Table creation is in `db.sql`. 

For web server rewrite rules, see https://gist.github.com/chriso/874000


Create a bash alias and use pasteros in your .bashrc! 
```
function uploadText {

pasteid=$( curl -silent -H "Expect:" -X POST --data-binary @- http://paste.gelat.in/api/v1/simplecreate | grep -o '[0-9]*' | tail -1)
echo "http://paste.gelat.in/$pasteid" # | xclip -selection c

}
alias paste=uploadText
```


`cat myfile.txt | paste`
