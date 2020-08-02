#include <stdio.h>
#include <sys/time.h>
#define MILLI_SEC 1000000

int main()
{
int cnt;
struct timespec req = {0, 500 * MILLI_SEC };

for (cnt=0;cnt<5;++cnt) {
  printf("実行中!!\n");

  if (nanosleep(&req, NULL) == -1) {
    perror(' ');
  }
}
printf("終了\n");

return 0;
}
