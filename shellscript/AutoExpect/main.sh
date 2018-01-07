#!/bin/bash -eu

TMP=wk_`date +"%Y%m%d_%H%M%S"`
mkdir ~/${TMP}

# download latest tools from svn server
./SVN.sh ${TMP}

# create result file(name:econfig)
./GEN_EXPEXT_TMP.sh -i user_config.txt econfig ${TMP}

# analyze config.txt
./GEN_EXPEXT_TMP.sh -u user_config.txt econfig

# generate LOGIN TEST script & exec
./GEN_ctl.sh -l econfig GEN_tel_ssh.sh GEN_su.sh
expect -f logintestscript

# analyze LOGIN TEST result
./GEN_EXPEXT_TMP.sh -c login_result econfig

# generate TRANSFER TEST script & exec
./GEN_ctl.sh -t econfig GEN_ftp_scp.sh GEN_mv.sh
expect -f transfertestscript

# analyze TRANSFER TEST result
./GEN_EXPEXT_TMP.sh -t trans_result econfig

# generate AUTO INSTALL script & exec
if [ "$1" = "RSCCHK" ];then
./GEN_ctl.sh -a econfig GEN_auto.sh install_RSCCHK.sh $2
expect -f autoinsscript 

elif [ "$2" = "GIJIKO" ];then
./GEN_ctl.sh -a econfig GEN_auto.sh install_GIJIKO.sh $2
expect -f autoinsscript 
fi

# clean all
./GEN_ctl.sh -C
./GEN_EXPEXT_TMP.sh -C
rm -f mod_install.sh mod_config.sh econfig .*
