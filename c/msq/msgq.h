#include <stdio.h>
#include <sys/types.h>
#include <sys/ipc.h>
#include <sys/msg.h>

// msqid
#define MSG_Q_ID 0x01

// mtype
#define DAY   1
#define NIGHT 2

// struct of message data
struct msg_data {
    int  id;
    char greeting[10];
};

// struct of message queue
struct msg {
    long             mtype;
    struct msg_data  data;
};
