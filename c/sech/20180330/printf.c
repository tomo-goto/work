#include <stdio.h>
#include "com.h"

void add_num_20(int *a){
*a+=20;
}
void add_num_30(int *a){
*a+=30;
}

void main(){
int a=10;
//struct sample b={100,200};
sample b={100,200};

printf("num is %d and %d\n",b.first,b.second);
add_num_20(&b.first);
printf("num is %d and %d\n",b.first,b.second);
add_num_30(&b.second);
printf("num is %d and %d\n",b.first,b.second);
}
