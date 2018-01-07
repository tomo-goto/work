#!/bin/bash

###########################################################
#-----------------------text format-----------------------#
###########################################################

str1=\
"# pri
00
# sio
03"

str2=\
"# dpc+opc+sls"

str3=\
"# SCCP Message Type(UDT:0x9 UDTS:0xa XUDT:0x11 XUDTS:0x12)"

str4=\
"# class
80
# Hop Counter(only XUDT)"

str5=\
"# CDPA Pointer"

str6=\
"# CGPA Pointer"

str7=\
"# User Data Pointer"

str8=\
"# Option Data Pointer(only XUDT)"

str9=\
"# CDPA"

str10=\
"# CGPA"

str11=\
"# User Data
78
00000000000000000000000000000000
00000000000000000000000000000000
00000000000000000000000000000000
00000000000000000000000000000000
00000000000000000000000000000000
622548020f786c1fa11d02010002012d
30158007911809444000368101008207
9193432900200000"

###########################################################
#-------------------------val set-------------------------#
###########################################################

#####dpc M
dM=`printf "%03d" $(echo "ibase=10;obase=2;${1:0:1}"|bc)`
#####dpc SSS
dS=`printf "%08d" $(echo "ibase=10;obase=2;${1:1:3}"|bc)`
#####dpc U
dU=`printf "%03d" $(echo "ibase=10;obase=2;${1:4:1}"|bc)`

#####opc M
oM=`printf "%03d" $(echo "ibase=10;obase=2;${2:0:1}"|bc)`
#####opc SSS
oS=`printf "%08d" $(echo "ibase=10;obase=2;${2:1:3}"|bc)`
#####opc U
oU=`printf "%03d" $(echo "ibase=10;obase=2;${2:4:1}"|bc)`

#####sls
sls=`printf "%04d\n" $3`

#####label
label=$sls$oM$oS$oU$dM$dS$dU

#####cdpaLen
if [ $((${#5}%2)) -eq 0 ];
then
#even
cdpaLen="$(((${#5}/2)+5))"
else
#odd
cdpaLen="$(((${#5}/2)+1+5))"
fi

#####cgpaLen
if [ $((${#6}%2)) -eq 0 ];
then
#even
cgpaLen="$(((${#6}/2)+5))"
else
#odd
cgpaLen="$(((${#6}/2)+1+5))"
fi

#####cdpa pointer
if [ `printf "%d" 0x$4` -eq `printf "%d" 0x11` ];
then
#xudt
cdpaPointer=$((3+1))
else
#no xudt
cdpaPointer=$((3))
fi

#####cgpa pointer
if [ `printf "%d" 0x$4` -eq `printf "%d" 0x11` ];
then
#xudt
cgpaPointer=$(($cdpaLen+3+1))
else
#no xudt
cgpaPointer=$(($cdpaLen+3))
fi

#####user data pointer
if [ `printf "%d" 0x$4` -eq `printf "%d" 0x11` ];
then
#xudt
userDataPointer=$(($cdpaLen+$cgpaLen+3+1))
else
#no xudt
userDataPointer=$(($cdpaLen+$cgpaLen+3))
fi

#####cdpaRev
cdpaOrg=$5
cdpaRev=""
end=""

while [ -z $end ];
do
#Swap First Byte
cdpaRev=$cdpaRev${cdpaOrg:1:1}${cdpaOrg:0:1}
cdpaOrg=${cdpaOrg:2}

#Last Byte
if [ ${#cdpaOrg} -eq 2 ];
then
cdpaRev=$cdpaRev${cdpaOrg:1:1}${cdpaOrg:0:1}
end=finish
elif [ ${#cdpaOrg} -eq 1 ];
then
cdpaRev=$cdpaRev`printf "%02d\n" $cdpaOrg`
end=finish
fi
done

######cgpaRev
cgpaOrg=$6
cgpaRev=""
end=""

while [ -z $end ];
do
#Swap First Byte
cgpaRev=$cgpaRev${cgpaOrg:1:1}${cgpaOrg:0:1}
cgpaOrg=${cgpaOrg:2}

#Last Byte
if [ ${#cgpaOrg} -eq 2 ];
then
cgpaRev=$cgpaRev${cgpaOrg:1:1}${cgpaOrg:0:1}
end=finish
elif [ ${#cgpaOrg} -eq 1 ];
then
cgpaRev=$cgpaRev`printf "%02d\n" $cgpaOrg`
end=finish
fi
done


###########################################################
#-----------------------output str -----------------------#
###########################################################

echo -e "$str1"
echo -e "\n"

echo -e "$str2"
printf "%02x\n" "0x`echo "obase=16;ibase=2;${label:24:8}"|bc`"
printf "%02x\n" "0x`echo "obase=16;ibase=2;${label:16:8}"|bc`"
printf "%02x\n" "0x`echo "obase=16;ibase=2;${label:8:8}"|bc`"
printf "%02x\n" "0x`echo "obase=16;ibase=2;${label:0:8}"|bc`"
echo -e "\n"

echo -e "$str3"
printf "%02x" "0x$4"
echo -e "\n"

echo -e "$str4"
if [ `printf "%d" 0x$4` -eq `printf "%d" 0x11` ];
then
printf "%02d" $7
fi
echo -e "\n"

echo -e "$str5"
printf "%02x" "$cdpaPointer"
echo -e "\n"

echo -e "$str6"
printf "%02x" "$cgpaPointer"
echo -e "\n"

echo -e "$str7"
printf "%02x" "$userDataPointer"
echo -e "\n"

echo -e "$str8"
if [ `printf "%d" 0x$4` -eq `printf "%d" 0x11` ];
then
printf "%02x" "$8"
fi
echo -e "\n"

echo -e "$str9"
printf "%02x\n" "$cdpaLen"
echo 1206001204
echo $cdpaRev
echo -e "\n"

echo -e "$str10"
printf "%02x\n" "$cgpaLen"
echo 1206001204
echo $cgpaRev
echo -e "\n"

echo -e "$str11"
echo -e "\n"
