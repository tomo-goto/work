#!/bin/bash
VER=$1
WK_DIR=$2

# common
cp -p mod_install.sh RSCCHK/${VER}/rsc_tool/INSTALL
cd RSCCHK/${VER}/rsc_tool/INSTALL
pwd
./mod_install.sh
./install.sh

if [ "${VER}" = "CGE3" ];then
# CGE3
  cd /root/SGW_rsctool/.tools/memchk/ps_check; make clean; make
  cd ~/${WK_DIR}
  cp -p mod_config.sh /root/SGW_rsctool
  cd /root/SGW_rsctool
  ./mod_config.sh

elif [ "${VER}" = "CGE4" ];then
# CGE4
  cd /root/SGW_rsctool/.tools/memchk/ps_check; make clean; make
  cd ~/${WK_DIR}
  cp -p mod_config.sh /root/SGW_rsctool
  cd /root/SGW_rsctool
  ./mod_config.sh

elif [ "${VER}" = "CGE6" ];then
# CGE6
  cd /home/root/SGW_rsctool/.tools/memchk/ps_check; make clean; make
  cd ~/${WK_DIR}
  cp -p mod_config.sh /home/root/SGW_rsctool
  cd /home/root/SGW_rsctool
  ./mod_config.sh

else
  echo "arg error"

fi
