
%{
#include <stdio.h>/* For I/O*/
#include <stdlib.h>/* For malloc here and in symbol table*/
#include <string.h>/* For strcmp in symbol table*/
#include "hashtable.h"

entry_ptr table[SIZE];



enum treetype {operator_node, number_node, variable_node};

typedef struct tree {
   enum treetype nodetype;
   union {
     struct {struct tree *left, *right; char operator;} an_operator;
     double a_number;
     char *a_variable;
      char chr;
      int rank;
   } body;
 } tree;

double eval_tree(tree * t);


 tree *make_operator (tree *l, char o, tree *r) {
   tree *result= (tree*)malloc(sizeof(tree));
   result->nodetype= operator_node;
   result->body.an_operator.left= l;
   result->body.an_operator.operator= o;
   result->body.an_operator.right= r;
   return result;
}
 tree *make_number (int n) {
   tree *result= (tree*)malloc(sizeof(tree));
   result->nodetype= number_node;
   result->body.a_number= n;
printf("%d\n",n);
   return result;
 }
 tree *make_variable (entry_ptr v) {
   tree *result= (tree*)malloc(sizeof(tree));
   result->nodetype= variable_node;
   printf("%s\n",v->symbol);
   result->body.a_variable= v->symbol;
   /*printf("%s\n", result->body.a_variable);*/
   result->body.a_number=v->value;
   /*printf("%lf\n\n", result->body.a_number);*/
   return result;
}

/*Print Tree */
 void printtree (tree *t, int level) {
#define step 4
   if (t)
     switch (t->nodetype)
     {
       case operator_node:
        printtree (t->body.an_operator.right, level+step);
        printf ("%*c%c\n", level, ' ', t->body.an_operator.operator);
        printtree (t->body.an_operator.left, level+step);
        break;
       case number_node:
        printf ("%*c%lf\n", level, ' ', t->body.a_number);
        break;
       case variable_node:                
        printf ("%*c%s\n", level, ' ',"id");
                break;
     }





 }



%}
%union {
double dval;
int ival;
char ch;
entry_ptr symp;
struct tree* a_tree;
}
%type <a_tree> factor expression_list statement  procedure_statement variable optional_statements compound_statement standard_type statement_list  declarations type subprogam_declaration subprogam_declarations subprogam_head identifier_list program arguments parameter_list  
%type <ival> sign
%start program
%type <ival> simple_expression expression term

%token <symp> NAME 
%token <dval> NUMBER 
%token YBEGIN END VAR ARRAY OF INTEGER FUNCTION ENDF PROCEDURE IF THEN ELSE WHILE DO 
%token <ch> RELOP MULOP ADDOP ASSIGNOP MOD AND DIV DIVISION COMMA DOTDOT NOT EQ NE LT LE GT GE COLON SEMICOLON LPAREN RPAREN LBRAC DOT RBRAC
%token <symp> PROGRAM
  
%token <ival> INT 
%token <dval> REAL 

%token <ival> PLUS MINUS OR
%left PLUS MINUS OR
%left MUL DIVISION DIV MOD AND
%%

program: PROGRAM NAME LPAREN identifier_list RPAREN SEMICOLON
declarations '\n'
subprogam_declarations '\n'
compound_statement DOT {$$=$9;}
 |  {}
;

identifier_list: NAME {$$=make_variable($1);}
| identifier_list COMMA NAME{$$=$1;}

;

declarations: declarations VAR identifier_list COLON type SEMICOLON
{$$=make_operator($3,$4,$5);}
 |   {}
;

type: standard_type {$$=$1;}
| ARRAY LBRAC NUMBER DOTDOT NUMBER RBRAC OF standard_type{}
;

standard_type: INT {$$->body.a_number=$1;}
| REAL  {$$->body.a_number=$1;}
;

subprogam_declarations: subprogam_declarations subprogam_declaration SEMICOLON {$$=$1;}
|{}
;

subprogam_declaration: 
subprogam_head 
declarations 
compound_statement {$$=$3;}
|{}
;

subprogam_head: FUNCTION NAME arguments COLON standard_type SEMICOLON{$$=make_operator($3,$4,$5);}
| PROCEDURE NAME arguments SEMICOLON{$$=$3;}
;

arguments: LPAREN parameter_list RPAREN{$$=$2;}
 |{}
;

parameter_list: identifier_list COLON type {$$=make_operator($1,$2,$3);}
| parameter_list SEMICOLON identifier_list COLON type
;

compound_statement: YBEGIN optional_statements END{$$=$2;}
;

optional_statements: statement_list {$$=$1;}
| {}
;

statement_list: statement {$$=$1;}
| statement_list SEMICOLON statement{$$=make_operator($1,$2,$3);}
;

statement: variable ASSIGNOP expression {$$=make_operator($1,$2,make_number($3));}
| procedure_statement{$$=$1;}
| compound_statement{$$=$1;}
| IF expression THEN statement ELSE statement{$$=$4; }
| WHILE expression DO statement{$$=$4;}
;

variable: NAME {$$=make_variable($1);}
| NAME LBRAC expression RBRAC{$$=make_number($3);}
;

procedure_statement: NAME {$$=make_variable($1);}
| NAME LPAREN expression_list RPAREN{$$=$3;}
;

expression_list: expression {$$=make_number($1);}
| expression_list COMMA expression{$$=make_operator($1,$2,make_number($3));}
;

expression: simple_expression{$$=$1;}
| simple_expression RELOP simple_expression
{$$=$1=$3;}
;

simple_expression: term {$$=$1;}
| sign term {$$=$2;}
| simple_expression ADDOP term{$$=$1+$3;}
;

term: factor {$$=$1->body.a_number;}
| term MULOP factor {$$=$1 *$3->body.a_number;}
;

factor: NAME {$$=make_variable($1); }
|NAME LPAREN expression_list RPAREN{$$->body.a_number=($1->funcptr)($3);}
|NAME LBRAC expression RBRAC{$$->body.a_number=($1->funcptr)($3);}
|NUMBER{$$->body.a_number=$1;} 
|LPAREN expression RPAREN {$$->body.a_number=$2;}
|NOT factor {$$=make_operator(NULL,$1,$2);}
;

sign: PLUS{$$=$1;printf("%c\n",$1);}
| MINUS   {$$=$1;printf("%c\n",$1);}
;


%%
main()
{
void initialize(entry_ptr table[]);
yyparse();
}
yyerror(s)
char *s;
{
fprintf(stderr,"%s\n",s);
}

/*
int adnop(int ex1,char o, int ex2)
{
int z;
int l,r;
l=ex1,r=ex2;
switch(o):
case '+':
z=ex1+ex2;
return z;break;
case '-':
z=ex1+ex2;
return z;


}
int relop(int l,char o,int r)
{
int z;
char c=o;
z=l 'c' r;
return z;

}

int mop(int l,char o,int r)
{
int z;
char c=o;
z=lcr;
return z;


}

 struct tree * whilestmt(int n, tree *t)
{
int x=n;
if(n)
return t;

}
struct tree * ifstmt(int n, tree *t1,tree *t2)
{
int x=n;
if(n)
return t1;
else
return t2;

}
struct tree * asop(tree *t1,tree *t2)
{

t1=t2;
return t1;

}*/
addfunc (name, func)
char *name;
double (*func)() ;
{
entry *sp = symlook(name);
sp->funcptr = func;
}

void initialize( entry_ptr table[])
{
int i=0;
for(i=0; i<SIZE; i++)
table[i] = NULL;
}


/*hash value*/

int hash_value(char * name)
{
int sum=0;
while( *name != '\0')
{
sum += *name;
name++;
}
return(sum % SIZE);

}
/* hash function */
int hashpjw(s)
char *s;

{
char *p;
unsigned h=0,g;
for(p=s;*p!='\0';p=p+1)
{
h=(h<<4)+(*p);
if(g= h&0xf0000000)
{
h=h^(g>>24);
h=h^g;
}
}
return h % 211; 
}

/*symbol lookup*/
entry *symlook(entry_ptr table[],char *name)
{
int h, flag=1;
entry_ptr temp;
h=hashpjw(name);
temp=table[h];
while( temp != NULL && flag )
{
if( strcmp(temp->symbol,name) == 0)
{
/*printf("The symbol %s is already present in thetable\n",name);*/
return temp;
flag =0;
}
temp=temp->next;
}
if(flag)/* adding */
{
temp = (entry_ptr) malloc(sizeof( entry));
if(temp == NULL)
{
yyerror("error\n");
exit(0);
}
strcpy(temp->symbol,name);
/*temp->value = val;*/
temp->next = table[h];
table[h]=temp;
return temp;
}
}

