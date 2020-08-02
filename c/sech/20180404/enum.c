#include <stdio.h>

enum number{
ONE = 1,
TWO
};

void sw(enum number n){

  switch(n){
    case ONE:
      printf("number ONE\n");
      break;
    case TWO:
      printf("number TWO\n");
      break;
  }
}

int main(){

  enum number tmp;
  tmp=TWO;

  sw(ONE);
  sw(tmp);

}
