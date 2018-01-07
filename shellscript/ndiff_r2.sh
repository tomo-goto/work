#!/bin/bash

###########################################################
#-----------------------PREPARATION-----------------------#
###########################################################

# $1 = oldsrc , $2 = newsrc
old_src_list=.old_src_list
new_src_list=.new_src_list
ndiff_list=.ndiff_list

# compare based on old sources
diff_files=.diff_files
old_files=.old_files
# compare based on new sources
new_files=.new_files

###########################################################
#-----------------------SUBROUTINE -----------------------#
###########################################################
# USAGE [ $1=oldsrc dir, $2=newsrc dir, $3=ndiff dir name ]
# TIPS: check arg & env
function CHK () {
				# arg check
if [ ! -d $1 ]; then
  echo "Wrong Argument! : $1 not exist"
  exit 1
elif [ ! -d $2 ]; then
  echo "Wrong Argument! : $2 not exist"
  exit 1
elif [ -e "${3}_old.tar.gz" ] || [ -e "${3}_new.tar.gz" ] || [ -e "${3}_ndiff.tar.gz" ]; then
  echo "File/Directory Already exist!"
  exit 1
elif [ $# != 3 ]; then
  echo "USAGE: ./ndiff.sh OLD_SOURCE NEW_SOURCE DIR_NAME"
  echo "EXECED -> $0 $*"
  exit 1
fi
				# env check
which ndiff > /dev/null
if [ $? -eq 1 ]; then
  echo "ndiff command not installed!"
  exit 1
fi
}
# USAGE [ $1=tmpfile name ]
# TIPS: check tmp files
function INIT () {
				# delete file named $1
if [ -f $1 ]; then
  rm  -f $1
				# error if $1 dir exist
elif [ -d $1 ];then
  echo "init error: dir named $1 exist!"
  exit 1
fi
}
# USAGE [ $1=DIR name for tar, $2=ORG(copy source), $3=file list ]
# TIPS: create sources tar.gz
function COPY () {
### start copy files ###
TAR=$1		# Tar name
ORG=$2		# Original source
LIST=$3		# File list

cat $LIST| while read line
do
				# get path of copy file from list
  DIR=`echo ${line}| awk -F "/" '{$NF="";print $0}'| sed -e 's/ /\//g'`
  DIR=$TAR/$DIR
				# create dir
  if [ ! -d $DIR ]; then
    mkdir -p $DIR
  fi
  tmp=`echo ${line}`
				# copy sources
  cp -p $ORG/${tmp:2} $DIR
done
}
# USAGE [ $1=DIR name for tar, $2=old ORG(copy source), $3=new ORG(copy source), $4=diff_files, $5=old_only_files, $6=new_only_files ]
# TIPS: create ndiff tar.gz
function NDIFF () {
TAR=$1
OLDORG=$2
NEWORG=$3
DIFF_LIST=$4
OLD_LIST=$5
NEW_LIST=$6

				# merge OLD, NEW, DIFF lists
LIST=.tmp_LIST
cat $OLD_LIST >> $LIST
cat $DIFF_LIST >> $LIST
cat $NEW_LIST >> $LIST
				# set LIST of empty file (for empty ndiff)
EMPTY=.tmp_EMPTY

mkdir $TAR; cd $TAR

cat ../$LIST| while read line
do
				# get path & filename from list
  FILE=`echo ${line}| awk -F "/" '{print $NF}'`
  DIR=`echo ${line}| awk -F "/" '{$NF="";print $0}'| sed -e 's/ /\//g'`
				# create dir
  if [ ! -d $DIR ]; then
    mkdir -p $DIR
  fi
  tmp=`echo ${line}`
				# check files
  if [ ! -f "../$OLDORG/${tmp:2}" ]; then
    touch ../$OLDORG/${tmp:2}
    echo ../$OLDORG/${tmp:2} >> $EMPTY
  elif [ ! -f "../$NEWORG/${tmp:2}" ]; then
    touch ../$NEWORG/${tmp:2}
    echo ../$NEWORG/${tmp:2} >> $EMPTY
  fi
				# create ndiff-command text
  echo  "ndiff ../$OLDORG/${tmp:2} ../$NEWORG/${tmp:2} > $DIR${FILE}_ndiff" >> tmp
done
				# execute ndiff-command
sh tmp;rm -f tmp
				# remove empty files
cat $EMPTY|while read line
do
  rm -f ${line}
done
				# remove list
cd ..
rm -f $LIST
}
###########################################################
#--------------------------MAIN --------------------------#
###########################################################

				# check args
CHK $1 $2 $3

				# initialize
INIT $old_src_list
INIT $new_src_list
INIT $ndiff_list
INIT $diff_files
INIT $old_files
INIT $new_files

				# create base lists (list of oldsrc and newsrc)
cd $1; find . -type f > ../$old_src_list; cd ..
cd $2; find . -type f > ../$new_src_list; cd ..

			#memo	# create diff list (diff... yes -> $?=1 , no -> $?=0)
				# and		   (grep... yes -> $?=0 , no -> $?=1)
				# old only list	   (ndiff... yes/no -> $?=0 , err -> $?=1)
cat $old_src_list | while read line
do
  grep -w ${line} $new_src_list > /dev/null	# grep with WORD(-w), perfect match
  if [ $? -eq 0 ]; then		# grep YES
    tmp=`echo ${line}`
#    echo $tmp
    diff ${1}${tmp:1} ${2}${tmp:1} > /dev/null # ./xxxx -> /xxxx (delete ".")
    if [ $? -eq 1 ]; then	# diff YES
      echo ${line} >> $diff_files
    fi
  elif [ $? -eq 1 ]; then	# grep NO
    echo ${line} >> $old_files
  fi
done

				# create new only list
cat $new_src_list | while read line
do
  grep -w ${line} $old_src_list > /dev/null
  if [ $? -eq 1 ]; then		# grep NO
    echo ${line} >> $new_files
  fi
done

				# create old_tar
# OLD_SRC $3 $1 $diff_files $old_files
COPY ${3}_old $1 $diff_files
COPY ${3}_old $1 $old_files
tar czfp ${3}_old.tar.gz ${3}_old

				# create new_tar
#NEW_SRC $3 $2 $diff_files $new_files
COPY ${3}_new $2 $diff_files
COPY ${3}_new $2 $new_files
tar czfp ${3}_new.tar.gz ${3}_new

				# create ndiff_tar
NDIFF ${3}_ndiff $1 $2 $diff_files $old_files $new_files
tar czfp ${3}_ndiff.tar.gz ${3}_ndiff
