#include <stdio.h>
#include <string.h>

void main(){

char str[] = "my name is tomo";
int i=0;
//while (str[i] != '\0'){
while (str[i] != '\0'){
  printf("%c",str[i]);
  i++;
}
printf("\n");

printf("%s\n",str);

}
