#include <stdio.h>
enum temp{
one = 1,
two,
three,
four,

ten = 10,
elv,
tlv,
tht
};

void main(){
int ary[][2] = { {1,2}, {3,4}};
//int ary[] = {1,2};

printf("num is %d\n",ary[1][0]);

int num =one;
printf("enum is %d\n",num);
printf("%d",tlv);
num = ten;
printf("%d\n",num);
}
