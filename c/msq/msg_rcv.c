#include "msgq.h"

int main(){

    int        qid;
    ssize_t    msq_ret;
    struct msg buf = {0};

    qid = msgget(MSG_Q_ID,
                 0666|IPC_CREAT);

    while(1){
        msq_ret = msgrcv(qid,
                  &buf,
                  sizeof(struct msg) - sizeof(long),
                  DAY, // no selection
                  0);
        printf("Greeting:[%s]\n", &(buf.data.greeting[0]));
        if( buf.mtype == NIGHT ){
            break;
        }
    }

    printf("ITs Night, Good Night Babe\n");
    return 0;
}
