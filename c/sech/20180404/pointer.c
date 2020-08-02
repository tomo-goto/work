#include <stdio.h>

struct data {
  int a;
  int b;
};

void dec_num(struct data* buf){
  buf->a=buf->a - 1;
  buf->b=buf->b - 1;
}

void chg_num(struct data *buf){
  buf->a=100;
  buf->b=1000;

  printf("NUM is %d and %d\n",buf->a,buf->b);

  dec_num(buf);
}

int main(){

struct data buf={0};

printf("num is %d and %d\n",buf.a, buf.b);
chg_num(&buf);
printf("num is %d and %d\n",buf.a, buf.b);

return 0;
}
