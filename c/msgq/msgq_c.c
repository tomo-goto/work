#include <sys/types.h>
#include <sys/ipc.h>
#include <sys/msg.h>
#include <unistd.h>
#include <stdio.h>


#define MSGKEY 75


/********************
 * メッセージ構造体 *
 ********************/
struct msgform
{
     long mtype;                /* メッセージタイプ(タグ) */
     char mtest[256];           /* メッセージ(任意の長さ) */
};


int main(void)
{
     struct msgform msg;
     int msgid;
     int pid;
     int *pint;

     /* MSGKEYに該当するメッセージキューIDを取得 */
     msgid = msgget(MSGKEY, 0777);

     pid = getpid();
     pint = (int *) msg.mtest;

     /* メッセージキューのデータ部分にclientプロセスのpidを格納 */
     *pint = pid;

     /* メッセージタグに1を指定 */
     msg.mtype = 1;

     /* メッセージの送信 */
     msgsnd(msgid, &msg, sizeof(int), 0);

     /* メッセージの受信 -> メッセージが存在しない場合はそのまま待機*/
     msgrcv(msgid, &msg, 256, pid, 0);

     printf("clinet: receve from pid %d\n", *pint);

     return 0;
}
