#include <stdio.h>
#include <string.h>


struct data {
  int a;
  int b;
};

void copy(struct data* src){
  struct data tmp={100};
  printf("NUM is %d and %d\n",tmp.a, tmp.b);

  memcpy(src, &tmp, sizeof(struct data));

}

int main(){
struct data src={0};

printf("num is %d and %d\n",src.a, src.b);
copy(&src);
printf("num is %d and %d\n",src.a, src.b);
memset(&src, 0, sizeof(struct data));
printf("num is %d and %d\n",src.a, src.b);
memcmp(&src, 

return 0;
}
