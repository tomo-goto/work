import sys

n_arg = int(sys.argv[1])

print("arguement is", n_arg, sep=' ... ')

n     = 0
n_flg = True

while n < n_arg:
  n += 1
  if( 5 < n ):
    n_flg = False
    break
  print("Hah! ", end='')
else:
  print("\n  ... END OF LOOP ...")


if( n_flg ):
  print("Finished master!")
else:
  print("I'm tired...")
