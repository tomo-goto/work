#!/bin/bash

###########################################################
#-----------------------PREPARATION-----------------------#
###########################################################
FB=$1
FBM=$FB?
make_log=makelog_merge.log
exec_log=execlog_merge.log

###########################################################
#-----------------------SUBROUTINE -----------------------#
###########################################################
# USAGE [ $1=FB, $2=make log, $3 executed log ]
# TIPS: generate cpptestcan under Module Directory
function MOD_MAKE () {

###variables###
cmdline="cpptestscan --cpptestscanRunOrigCmd=no --cpptestscanOutputFile=`cd ../..;pwd`/cpptestscan.$1 "
  # |-> generate "$cmdline + trimmed-make-log" strings
makelog=.make_log			#logname of make result (tmp file)
trimlog=.makelog_trim			#logname of trimed "make log" (tmp file)
logmerge=$2				#logname of merged $makelog
gencmdlog=$3				#logname of merged execute log

###main###
make clean &> /dev/null			# execute make clean
make &> $makelog			# execute make

flg_continue=0
cat $makelog | while read line
do
  					# find line starts with "/usr/bin/gcc"
  echo ${line} | \grep -E "^/usr/bin/gcc" &> /dev/null

  if [ $? -eq 0 ]; then			# if switch1 -> ^[ /usr/bin/gcc | ELSE ] (regex)
    					# extract(sed) gcc OPTIONS
    echo ${line} | sed -e 's/\/usr\/bin\/gcc //' | echo ${cmdline}`cat` >> $trimlog
    					# line ends with "\" -> flag up (for returned string)
    tmp=`echo ${line} | rev | cut -c 1-1`

    if [ $tmp = "\\" ]; then		# if switch2 -> [ \ | ELSE ]$ (regex)
      flg_continue=1
    else
      flg_continue=0
    fi					# if switch2 END

  elif [ $flg_continue -eq 1 ]; then	# previous line ended with "\" ("\" means return in makelog)
    echo ${line} >> $trimlog
  fi					# if switch1 END
done

					# execute cpptestscan
bash $trimlog

					# merge logs
cat $makelog >> ../../$logmerge
cat $trimlog >> ../../$genlog
rm -f $makelog $trimlog			# remove fragment log
}

###########################################################
#--------------------------MAIN --------------------------#
###########################################################

					# list of modules for loop
module_list=.module_`date +"%T"`
find -name "com" -or -name "lib" -type d | grep -E */$FBM/* > $module_list

					# dup backup
if [ -f $make_log ]; then
mv $make_log "${make_log}_`date +"%H%M%S"`"
fi

if [ -f $exec_log ]; then
mv $exec_log "${exec_log}_`date +"%H%M%S"`"
fi

if [ -f cpptestscan.$FB ]; then
mv cpptestscan.$FB "cpptestscan.${FB}_`date +"%H%M%S"`"
fi

					# start generating cpptestscan file
cat $module_list | while read line
do
cd ${line}
MOD_MAKE $FB $make_log $exec_log
cd ../..
done

rm -f $module_list
