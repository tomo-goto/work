n_tmp  = 0
n_list = ["want", "have", "a job"]
n_list.append(", seriously")

for n_word in n_list:
  n_tmp+=1
  if( n_tmp < len(n_list) ):
    print( n_word + " ", end='' )
  else:
    print( n_word, end='' )

print(".\n")



"""Other methods are listed below.
reverse()
sort()
count(%s)
clear()
copy()         => Returns a copy of the list.
                  (Gives reference if not using this method?)
extend(%obj)   => Add the elements of a list (or any iterable), to the end
index(%s)      => Returns the index of the first element with the specified value
insert(%d, %s) => Adds an element at the specified position
pop(%d)        => Removes the elemet at the specified position
remove(%s)     => Removes the item with the specified value
"""
