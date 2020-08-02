#include "msgq.h"
#include <string.h>

int main(){

    int        qid;
    ssize_t    msq_ret;
    struct msg buf = {0};
    char       mess[10] = "hey";

    qid = msgget(MSG_Q_ID,
                 0666|IPC_CREAT);

    // buf set
    buf.mtype   = DAY;
    buf.data.id = 1;
    memcpy(&(buf.data.greeting[0]), &(mess[0]), 10);

    msq_ret = msgsnd(qid,
              &buf,
              sizeof(struct msg) - sizeof(long),
              IPC_NOWAIT);
    printf("Send Message. Type:[%d] Id:[%d] Greeting:[%s]\n",
           buf.mtype ,buf.data.id, &(buf.data.greeting[0]));

    return 0;
}
