import sys


a     = 33
n_arg = int(sys.argv[1])

print("arguement is", n_arg, sep=' ... ')

if a < n_arg:
  print("arguement is greater than ", a)
  exit()
elif a == n_arg:
  pass
else:
  print("arguement is smaller than ", a)
  exit()

print("arguement and ", a, " are equal")
