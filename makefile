all: 2 1 3
1:
	lex scanner.l
2:
	yacc -d parser.y
3:
	gcc -o calc lex.yy.c y.tab.c -ly -ll
4:
	gcc -o lexer lex.yy.c -ll
5:
	gcc -o parser y.tab.c -ll -ly
clean:
	rm -f *.*~ *~ *.o *.c lexer parser calc 
