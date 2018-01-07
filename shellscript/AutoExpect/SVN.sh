#!/bin/bash

###########################################################
#-----------------------PREPARATION-----------------------#
###########################################################
SVN_IP=XXX.XXX.XXX.XXX
SVN_USR=root
SVN_PWD=

FST_IP=XXX.XXX.XXX.XXX
FST_USR=root
FST_PWD=

###########################################################
#-----------------------SUBROUTINE -----------------------#
###########################################################
function SVN {
				# Preparation
DIR=$1

SVN_DIR=${DIR}
EX_PWD="*assword:"	#expect keyword for ssh/scp password
EX_PMT="$ "		#expect keyword for prompt

				# Start expect
expect -c "
set timeout 60
spawn ssh ${SVN_USR}@${SVN_IP}
expect \"${EX_PWD}\"
send \"${SVN_PWD}\n\"
expect \"${EX_PMT}\"

				# Checkout latest ver from SVN
send \"mkdir ${SVN_DIR}\n\"
expect \"${EX_PMT}\"
send \"cd ${SVN_DIR}\n\"
expect \"${EX_PMT}\"
send \"svn co svn://${SVN_IP}/GIJIKO\n\"
expect \"${EX_PMT}\"
send \"svn co svn://${SVN_IP}/RSCCHK\n\"
expect \"${EX_PMT}\"
send \"find -name .svn | xargs rm -rf\n\"
expect \"${EX_PMT}\"
send \"tar cfzp tool.tgz GIJIKO RSCCHK\n\"
expect \"${EX_PMT}\"

				# Download (SVN to ORG)
send \"scp tool.tgz ${FST_USR}@${FST_IP}:~/${DIR}\n\"
expect \"${EX_PWD}\"
send \"${FST_PWD}\n\"
expect \"${EX_PMT}\"

				# Delete WK directory
send \"cd ..;rm -rf ${SVN_DIR}\n\"
expect \"${EX_PMT}\"

exit 0
"

}

function GEN_MODSH {
SH=$1
TXT=$2
MOD_SH=$3

ORG_SH=mod_template.sh
cp -p ${ORG_SH} ${MOD_SH}

cat ${TXT}| while read line
do
TXT_KEY=`echo ${line}|awk -F "=" '{print $1}'`
TXT_PRM=`echo ${line}|sed "s/${TXT_KEY}=//"`
echo "MOD_PRM ${TXT_KEY} ${TXT_PRM} ${SH}" >> ${MOD_SH}
done
}

###########################################################
#--------------------------MAIN --------------------------#
###########################################################
SVN $1
echo "SVN end sleep 5s"
sleep 5
pwd

GEN_MODSH "install.sh" "install.txt" "mod_install.sh"
GEN_MODSH "config.sh" "config.txt" "mod_config.sh"

cp -p install_RSCCHK.sh mod_install.sh mod_config.sh install_GIJIKO.sh ~/$1
O_DIR=`pwd`
cd ~/$1
tar xzfp tool.tgz
tar czfp tool.tgz *.sh GIJIKO RSCCHK
cd ${O_DIR}
