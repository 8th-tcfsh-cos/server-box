a=1
for i in *.jpg; do
  new=$(printf "%04d.jpg" 17-$a) #04 pad to length of 4
  mv -i -- "$i" "$new"
  let a=a+1
done
