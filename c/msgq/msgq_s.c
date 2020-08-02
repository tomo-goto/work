#include <sys/types.h>
#include <sys/ipc.h>
#include <sys/msg.h>
#include <unistd.h>
#include <stdio.h>
#include <stdlib.h>
#include <signal.h>


#define MSGKEY 75


/********************
 * メッセージ構造体 *
 ********************/
struct msgform
{
     long mtype;                /* メッセージタイプ(タグ) */
     char mtest[256];           /* メッセージ(任意の長さ) */
};

int msgid;


/****************************
 * メッセージキュー削除関数 *
 ****************************/
void cleanup(int n)
{
     msgctl(msgid, IPC_RMID, 0);
     exit(0);
}

int main(void)
{
     struct msgform msg;
     int pid;
     int *pint;
     int i;
     extern void cleanup();

     /* シグナル 0-19 を受取ったらcleanu()をcall */
     for (i = 0; i < 20; i++) {
          signal(i, cleanup);
     }

     /* 新たなメッセージキューリンクトリストを作成 */
     msgid = msgget(MSGKEY, 0777|IPC_CREAT);

     for (;;) {
          /**************************
           * メッセージキュー受信処理 *
           **************************/

          /* 1. メッセージキュー識別子(キューID)
           * 2. 受信したメッセージの格納先
           * 3. サイズ
           * 4. 読込むメッセージのタイプ(タグ)
           *    0 -> キューの最初のメッセージ
           *  > 0 -> 指定したタグの最初のメッセージ(MSG_EXCEPTが指定されれば型以外
           *         の最初のメッセージ)
           *  < 0 -> 指定値の絶対値以下のタグを持つメッセージの中で最小のメッセ
           *         ージ(タグをメッセージの優先度と考える)
           * 5. メッセージキューにメッセージが無かった場合の動作の指定
           * ※メッセージが存在しない場合はそのまま待機(挙動はフラグで指定可能)
           */
          msgrcv(msgid, &msg, 256, 1, 0);
          pint = (int *) msg.mtest;

          /* 受信したメッセージからデータ部分取得(clientのプロセスID) */
          pid = *pint;

          printf("server: receve from pid %d\n", pid);

          /* メッセージタグとしてclientプロセスのpidを指定 */
          msg.mtype = pid;

          /* メッセージのデータ部分にserverプロセスのpidを指定 */
          *pint = getpid();

          /* メッセージ送信(リンクトリストに追加) */
          msgsnd(msgid, &msg, sizeof(int), 0);
     }
     return 0;
}
