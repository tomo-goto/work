#include <stdio.h>

struct Fstudy{
   int a;
   int b;
};

void chg_num(struct Fstudy* tmp){
  tmp->a=100;
  tmp->b=1000;
}

void main(){

struct Fstudy data;
//data->a = 1;
//data->b = 2;

data.a = 1;
data.b = 2;

//printf("num is %d and %d\n",data->a,data->b);

printf("num is %d and %d\n",data.a,data.b);
chg_num(&data);
printf("num is %d and %d\n",data.a,data.b);

}
