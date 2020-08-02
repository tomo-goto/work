print "aaa\n" x 10;
print "$ENV{'PATH'}\n";

 $string = <STDIN>;

 #$string = "aa";

if( $string eq "aa\n"){
  print "my name is $string\n";
  exit;
}

if( $string == 0 ){
  print "input was 0";
}
else{
  print "ERR";
}

