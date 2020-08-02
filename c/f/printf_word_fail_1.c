#include <stdio.h>
#include <stdlib.h>
#include <pthread.h>

void loop_printf(int num){
printf("given number is %d\n",num);
}
int main(int argc, char *argv[]){
int arg;
if(argc < 2){
  fprintf(stderr, "Usage: needs more than 2 arguements\n");
  exit(EXIT_FAILURE);
}

while(*argv[1] != '\0'){
printf("word = %s\n", argv[1]);
++argv[1];
}

arg = atoi(argv[1]);
loop_printf(arg);

return ;
}
