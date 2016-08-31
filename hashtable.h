
#define SIZE 211
#define MAX 10


typedef struct node
{
char symbol[MAX];
double value;
double (*funcptr)();
struct node *next;
} entry;



typedef entry * entry_ptr;
entry_ptr symlook();

/*initialize entry_ptr table*/





