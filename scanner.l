%{
#include "hashtable.h"
#include "y.tab.h"


#include <string.h>

entry_ptr table[SIZE];
/*definitions of manifest constants*/


%}

%%
[0-9]+  {yylval.dval=atof(yytext);}

[ \t];


program  {return PROGRAM;}
begin    {return YBEGIN;}
end      {return END;}
var      {return VAR;}
array    {return ARRAY;}
of       {return OF;}
integer  {return INTEGER;}
real     {return REAL;}
function   {return FUNCTION;}
procedure  {return PROCEDURE;}
if         {return IF;}
then       {return THEN;}
else       {return ELSE;}
while      {return WHILE;}
do         {return DO;}
not        {return NOT;}

"="       {yylval.ival=EQ; return(RELOP);}
"<>"      {yylval.ival=NE; return(RELOP);}
"<"       {yylval.ival=LT;return(RELOP);}
"<="      {yylval.ival=LE;return(RELOP);}
">"       {yylval.ival=GT;return(RELOP);}
">="      {yylval.ival=GE;return(RELOP);}

"+"       {yylval.ival=PLUS;return(ADDOP);}
"-"       {yylval.ival=MINUS; return(ADDOP);}
"or"        {yylval.ival=OR;return(ADDOP);}


"*"       {yylval.ival=MUL;return(MULOP);}
"/"       {yylval.ival=DIVISION;return(MULOP);}
"div"     {yylval.ival=DIV;return(MULOP);}
"mod"     {yylval.ival=MOD;return(MULOP);}
"and"     {yylval.ival=AND;return(MULOP);}

":="      {return(ASSIGNOP);}
".."      {return(DOTDOT);}
":"    return(COLON);
","    return(COMMA);
"["    return(LBRAC);
"("    return(LPAREN);
"]"    return(RBRAC);
")"    return(RPAREN);
";"    return(SEMICOLON);
"."    return(DOT);



[A-Za-z][A-Za-z0-9]* {yylval.symp=symlook(table,yytext);
 return NAME;}
"$" return 0;
. | \n return yytext[0];

%%
int yywrap(void){}
