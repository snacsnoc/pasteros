This is the source code for pasteros.io

Configuration for PostgreSQL is in `public/index.php`. Table creation is in `db.sql`. 

For web server rewrite rules, see https://gist.github.com/chriso/874000


Create a bash alias and use pasteros in your .bashrc! 
```
function uploadText {
pasteid=$( curl -silent -H "Expect:" -X POST --data-binary @- https://pasteros.io/api/v1/simplecreate | tail -1)
echo "https://pasteros.io/$pasteid"  | xclip -selection c
}
alias paste=uploadText
```


`cat myfile.txt | paste`

Create a `cache` directory in the main folder
