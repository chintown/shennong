# ex:ts=8:sw=8:noexpandtab
#.PHONY: clean

CWD := $(shell pwd)

taste_truth:
	@php -f $(CWD)/tries/truth.php;

taste_equation:
	@php -f $(CWD)/tries/equation.php;

taste_null_empty_util:
	@php -f $(CWD)/tries/null_empty_utils.php;