n_tmp  = 0
n_list = ["Say", "hello", "to new world"]

for word in n_list:
  n_tmp+=1
  if( n_tmp < len(n_list) ):
    print( word + " ", end="" )
  else:
    print( word, end="" )
print(".")

print("")
print( "Python also have reserved word like \"continue\" and \"pass\"" )
print( "-> \"for\" statement can not be blank, so use \"pass\"" )
