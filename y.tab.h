/* A Bison parser, made by GNU Bison 2.5.  */

/* Bison interface for Yacc-like parsers in C
   
      Copyright (C) 1984, 1989-1990, 2000-2011 Free Software Foundation, Inc.
   
   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.
   
   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.
   
   You should have received a copy of the GNU General Public License
   along with this program.  If not, see <http://www.gnu.org/licenses/>.  */

/* As a special exception, you may create a larger work that contains
   part or all of the Bison parser skeleton and distribute that work
   under terms of your choice, so long as that work isn't itself a
   parser generator using the skeleton or a modified version thereof
   as a parser skeleton.  Alternatively, if you modify or redistribute
   the parser skeleton itself, you may (at your option) remove this
   special exception, which will cause the skeleton and the resulting
   Bison output files to be licensed under the GNU General Public
   License without this special exception.
   
   This special exception was added by the Free Software Foundation in
   version 2.2 of Bison.  */


/* Tokens.  */
#ifndef YYTOKENTYPE
# define YYTOKENTYPE
   /* Put the tokens into the symbol table, so that GDB and other debuggers
      know about them.  */
   enum yytokentype {
     NAME = 258,
     NUMBER = 259,
     YBEGIN = 260,
     END = 261,
     VAR = 262,
     ARRAY = 263,
     OF = 264,
     INTEGER = 265,
     FUNCTION = 266,
     ENDF = 267,
     PROCEDURE = 268,
     IF = 269,
     THEN = 270,
     ELSE = 271,
     WHILE = 272,
     DO = 273,
     RELOP = 274,
     MULOP = 275,
     ADDOP = 276,
     ASSIGNOP = 277,
     MOD = 278,
     AND = 279,
     DIV = 280,
     DIVISION = 281,
     COMMA = 282,
     DOTDOT = 283,
     NOT = 284,
     EQ = 285,
     NE = 286,
     LT = 287,
     LE = 288,
     GT = 289,
     GE = 290,
     COLON = 291,
     SEMICOLON = 292,
     LPAREN = 293,
     RPAREN = 294,
     LBRAC = 295,
     DOT = 296,
     RBRAC = 297,
     PROGRAM = 298,
     INT = 299,
     REAL = 300,
     PLUS = 301,
     MINUS = 302,
     OR = 303,
     MUL = 304
   };
#endif
/* Tokens.  */
#define NAME 258
#define NUMBER 259
#define YBEGIN 260
#define END 261
#define VAR 262
#define ARRAY 263
#define OF 264
#define INTEGER 265
#define FUNCTION 266
#define ENDF 267
#define PROCEDURE 268
#define IF 269
#define THEN 270
#define ELSE 271
#define WHILE 272
#define DO 273
#define RELOP 274
#define MULOP 275
#define ADDOP 276
#define ASSIGNOP 277
#define MOD 278
#define AND 279
#define DIV 280
#define DIVISION 281
#define COMMA 282
#define DOTDOT 283
#define NOT 284
#define EQ 285
#define NE 286
#define LT 287
#define LE 288
#define GT 289
#define GE 290
#define COLON 291
#define SEMICOLON 292
#define LPAREN 293
#define RPAREN 294
#define LBRAC 295
#define DOT 296
#define RBRAC 297
#define PROGRAM 298
#define INT 299
#define REAL 300
#define PLUS 301
#define MINUS 302
#define OR 303
#define MUL 304




#if ! defined YYSTYPE && ! defined YYSTYPE_IS_DECLARED
typedef union YYSTYPE
{

/* Line 2068 of yacc.c  */
#line 82 "parser.y"

double dval;
int ival;
char ch;
entry_ptr symp;
struct tree* a_tree;



/* Line 2068 of yacc.c  */
#line 158 "y.tab.h"
} YYSTYPE;
# define YYSTYPE_IS_TRIVIAL 1
# define yystype YYSTYPE /* obsolescent; will be withdrawn */
# define YYSTYPE_IS_DECLARED 1
#endif

extern YYSTYPE yylval;


