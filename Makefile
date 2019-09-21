.DEFAULT_GOAL := build
.PHONY: build
build: dev/mi11er-utility.$(VERSION).zip
dev:
	@mkdir -p dev

dev/mi11er-utility.$(VERSION).zip: | dev
	@git archive --format=zip --prefix=mi11er-utility/ -o "$@" $(VERSION)

